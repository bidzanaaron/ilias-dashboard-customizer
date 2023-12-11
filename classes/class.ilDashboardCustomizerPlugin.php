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

class ilDashboardCustomizerPlugin extends ilUserInterfaceHookPlugin
{
    private const CTYPE = 'Services';
    private const CNAME = 'UIComponent';
    private const SLOT_ID = 'uihk';
    private const PNAME = 'DashboardCustomizer';
    private static ?self $instance = null;

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            global $DIC;
            self::$instance = $DIC['component.factory']->getPlugin('dbc');
        }

        return self::$instance;
    }

    public function getPluginName(): string
    {
        return self::PNAME;
    }

}