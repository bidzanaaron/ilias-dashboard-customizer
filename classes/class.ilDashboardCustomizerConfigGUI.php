<?php

/**
 * This file is part of ILIAS, a powerful learning management system
 * published by ILIAS open source e-Learning e.V.
 *
 * ILIAS is licensed with the GPL-3.0,
 * see https://www.gnu.org/licenses/gpl-3.0.en.html
 * You should have received a copy of said license along with the
 * source code, too.
 *
 * If this is not the case or you just want to try ILIAS, you'll find
 * us at:
 * https://www.ilias.de
 * https://github.com/ILIAS-eLearning
 *
 *********************************************************************/

declare(strict_types=1);

use ILIAS\DI\Container;

/**
 * @ilCtrl_IsCalledBy ilDashboardCustomizerConfigGUI: ilObjComponentSettingsGUI
 */
class ilDashboardCustomizerConfigGUI extends ilPluginConfigGUI
{
    protected Container $dic;
    protected ilDashboardCustomizerPlugin $plugin;
    protected ilSetting $settings;

    const PLUGIN_ID = 'uihk_dbc';

    public function __construct()
    {
        global $DIC;

        $this->dic = $DIC;
        $this->plugin = ilDashboardCustomizerPlugin::getInstance();
        $this->settings = new ilSetting('dbc');
    }

    public static function getWelcomeTitle(): ?string
    {
        return ilSetting::_lookupValue('dbc', 'dbc_welcome_title');
    }

    public static function getWelcomeMessage(): ?string
    {
        return ilSetting::_lookupValue('dbc', 'dbc_welcome_message');
    }

    public function performCommand(string $cmd): void
    {
        $this->buildTabs();
        $this->dic->tabs()->activateTab('settings');
        switch (strtolower($cmd)) {
            case 'save':
                $this->save();
                break;
            case 'configure':
            default:
                $this->showSettingsForm();
                break;
        }
    }

    protected function buildTabs(): void
    {
        $this->dic->tabs()->addTab(
            'settings',
            $this->plugin->txt('settings'),
            $this->dic->ctrl()->getLinkTarget($this, 'configure')
        );
    }

    public function getSettingsForm(): ilPropertyFormGUI
    {
        $form = new ilPropertyFormGUI();

        $form->setFormAction($this->dic->ctrl()->getFormAction($this));
        $form->setTitle($this->plugin->txt('welcome_message'));
        $form->addCommandButton('save', $this->dic->language()->txt('save'));

        $welcome_title = new ilTextInputGUI($this->plugin->txt('title'), 'dbc_welcome_title');
        $welcome_title->setValue($this->settings->get('dbc_welcome_title', ''));
        $form->addItem($welcome_title);

        $welcome_message = new ilTextAreaInputGUI($this->plugin->txt('message'), 'dbc_welcome_message');
        $welcome_message->setValue($this->settings->get('dbc_welcome_message', ''));
        $welcome_message->setRequired(true);
        $form->addItem($welcome_message);

        return $form;
    }

    public function showSettingsForm(): void
    {
        $form = $this->getSettingsForm();
        $this->dic->ui()->mainTemplate()->setContent($form->getHTML());
    }

    public function save(): void
    {
        $form = $this->getSettingsForm();
        if ($form->checkInput()) {
            foreach ($this->dic->http()->request()->getParsedBody() as $post_data_key => $post_data_value) {
                if ($post_data_key === 'cmd') {
                    continue;
                }

                if ($post_data_value . $post_data_key === '') {
                    continue;
                }

                if (is_array($post_data_value)) {
                    $post_data_value = implode(',', $post_data_value);
                }

                $this->settings->set($post_data_key, $post_data_value);
            }

            $this->dic->ctrl()->redirect($this, 'configure');
        } else {
            $form->setValuesByPost();
            $this->dic->ui()->mainTemplate()->setContent($form->getHTML());
        }
    }
}