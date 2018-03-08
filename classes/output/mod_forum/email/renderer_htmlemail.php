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

namespace theme_moove\output\mod_forum\email;
defined('MOODLE_INTERNAL') || die();
/**
 * Forum post renderable.
 *
 * @since      Moodle 3.0
 * @package    theme_moove
 * @copyright  2017 David Bogner <info@edulabs.org> and Gareth Barnard
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer_htmlemail extends \mod_forum\output\email\renderer {
    /**
     * Display a forum post in the relevant context.
     *
     * @param \mod_forum\output\forum_post $post The post to display.
     * @return string
     */
    public function render_forum_post_email(\mod_forum\output\forum_post_email $post) {
        global $SITE, $OUTPUT;

        // Was ($this, $this->target === RENDERER_TARGET_TEXTEMAIL) and as we are already 'htmlemail' it will always be false.
        $data = $post->export_for_template($this, false);
        // Add our new data.
        $data['enabletemplate'] = theme_moove_get_setting('forumcustomtemplate');
        $forumhtmlemailheader = theme_moove_get_setting('forumhtmlemailheader', 'format_html');
        if ($forumhtmlemailheader) {
           $data['messageheader'] = $forumhtmlemailheader;
        }

        $forumhtmlemailfooter = theme_moove_get_setting('forumhtmlemailfooter', 'format_html');
        if ($forumhtmlemailfooter) {
           $data['messagefooter'] = $forumhtmlemailfooter;
        }

        $data['sitelogo'] = false;

        $theme = \theme_config::load('moove');

        $logo = $theme->setting_file_url('logo', 'logo');
        if ($logo) {
            $data['sitelogo'] = $logo;
            $data['sitelogo'] = 'https://www.moodlebrasil.org/pluginfile.php/1/theme_adaptable/logo/1520291519/mootbr.png';
        }

        $data['sitename'] = $SITE->fullname;

        return $this->render_from_template('mod_forum/' . $this->forum_post_template(), $data);
    }
}