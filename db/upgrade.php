<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Theme UPO upgrade.
 *
 * @package    theme_upo
 * @copyright  2014 Roberto Pinna
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Theme_UPO upgrade function.
 *
 * @param  int $oldversion The version we upgrade from.
 * @return bool
 */
function xmldb_theme_upo_upgrade($oldversion) {
    global $CFG;

    if ($oldversion < 2014032400) {

        // Set the default background. If an image is already there then ignore.
        $fs = get_file_storage();
        $bg = $fs->get_area_files(context_system::instance()->id, 'theme_upo', 'backgroundimage', 0);

        // Add default background image.
        if (empty($bg)) {
            $filerecord = new stdClass();
            $filerecord->component = 'theme_upo';
            $filerecord->contextid = context_system::instance()->id;
            $filerecord->userid    = get_admin()->id;
            $filerecord->filearea  = 'backgroundimage';
            $filerecord->filepath  = '/';
            $filerecord->itemid    = 0;
            $filerecord->filename  = 'background.jpg';
            $fs->create_file_from_pathname($filerecord, $CFG->dirroot . '/theme/upo/pix/background.jpg');
        }

        upgrade_plugin_savepoint(true, 2014032400, 'theme', 'upo');

    }

    if ($oldversion < 2014032401) {

        // Set the default settings as they might already be set.
        set_config('textcolor', '#333366', 'theme_upo');
        set_config('linkcolor', '#FF6500', 'theme_upo');
        set_config('backgroundrepeat', 'repeat', 'theme_upo');
        set_config('contentbackground', '#FFFFFF', 'theme_upo');
        set_config('secondarybackground', '#FFFFFF', 'theme_upo');
        set_config('invert', 1, 'theme_upo');
        set_config('backgroundimage', '/background.jpg', 'theme_upo');

        upgrade_plugin_savepoint(true, 2014032401, 'theme', 'upo');
    }

    // Moodle v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    if ($oldversion < 2016090100) {
        upgrade_plugin_savepoint(true, 2016090100, 'theme', 'upo');
    }

    return true;
}
