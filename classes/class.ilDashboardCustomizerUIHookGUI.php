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

/**
 * Class ilDashboardCustomizerUIHookGUI
 *
 * @author Aaron Bidzan <abidzan@databay.de>
 */
class ilDashboardCustomizerUIHookGUI extends ilUIHookPluginGUI
{
    public function getHTML(string $a_comp, string $a_part, array $a_par = array()): array
    {
        if ($a_comp === 'Services/Dashboard' && $a_part === 'center_column') {
            $welcome_title = ilDashboardCustomizerConfigGUI::getWelcomeTitle();
            $welcome_message = ilDashboardCustomizerConfigGUI::getWelcomeMessage();

            $tpl = $this->plugin_object->getTemplate('tpl.welcome_message.html', true, true);

            $tpl->setVariable('TITLE', $welcome_title);
            $tpl->setVariable('MESSAGE', $welcome_message);

            return ['mode' => ilUIHookPluginGUI::PREPEND, 'html' => $tpl->get()];
        }

        return ['mode' => ilUIHookPluginGUI::KEEP, 'html' => ''];
    }
}