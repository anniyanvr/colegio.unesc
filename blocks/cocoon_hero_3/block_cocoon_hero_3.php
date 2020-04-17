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

defined('MOODLE_INTERNAL') || die();

class block_cocoon_hero_3 extends block_base {

    /**
     * Initialises the block.
     *
     * @return void
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_cocoon_hero_3');
    }

    /**
     * The block is usable in all pages
     */
     function applicable_formats() {
         return array(
           'all' => true,
           'my' => false,
         );
     }


    /**
     * Customize the block title dynamically.
     */
    function specialization() {
        if (isset($this->config->title)) {
            $this->title = $this->title = format_string($this->config->title, true, ['context' => $this->context]);
        } else {
            $this->title = get_string('newcustomsliderblock', 'block_cocoon_hero_3');
        }
    }

    /**
     * The block can be used repeatedly in a page.
     */
    function instance_allow_multiple() {
        return true;
    }

    /**
     * Gets the block contents.
     *
     * If we can avoid it better not check the server status here as connecting
     * to the server will slow down the whole page load.
     *
     * @return string The block HTML.
     */
    public function get_content() {
        global $OUTPUT, $CFG, $PAGE;

        require_once($CFG->libdir . '/filelib.php');

        if ($this->content !== null) {
            return $this->content;
        }

        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 0;
        } else {
            $data = new stdClass();
            $data->slidesnumber = 0;
        }

        $this->content = new stdClass();
        $this->content->footer = '';
        $this->content->text = '';
        if(!empty($this->config->title)){$this->content->title = $this->config->title;}
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;}
        if ($data->slidesnumber > 0) {
          $this->content->text .= '
          <section id="maximage1" class="maximage-home home-four p0">
            <div class="container-fluid p0">
              <!-- Basic HTML -->
                <div id="maximage">';
                $fs = get_file_storage();
                for ($i = 1; $i <= $data->slidesnumber; $i++) {
                  $sliderimage = 'file_slide' . $i;
                  if (!empty($data->$sliderimage)) {
                    $files = $fs->get_area_files($this->context->id, 'block_cocoon_hero_3', 'slides', $i, 'sortorder DESC, id ASC', false, 0, 0, 1);
                    if (count($files) >= 1) {
                      $mainfile = reset($files);
                      $mainfile = $mainfile->get_filename();
                    } else {
                      continue;
                    }
                    $this->content->text .= '
                    <div class="first-item">
                      <img src="' . moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/{$this->context->id}/block_cocoon_hero_3/slides/" . $i . '/' . $mainfile) . '" alt=""/>
                    </div>';
                  }
                }
                $this->content->text .= '
                </div>
                  <div class="maxslider-content">
                    <div class="lbox-caption">
                      <div class="lbox-details">
                        <div class="maxtext">
                          <h1>'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h1>
                          <p>'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
                          <div class="search_box_home4">
                            <div class="ht_search_widget">
                              <div class="header_search_widget">';
                // Begin Search form
                if (\core_search\manager::is_global_search_enabled() === false) {
                    $this->content->text = get_string('globalsearchdisabled', 'search');
                    return $this->content;
                }

                $url = new moodle_url('/search/index.php');

                $this->content->text .= html_writer::start_tag('form', array('class' => 'form-inline mailchimp_form', 'action' => $url->out()));
                $this->content->text .= html_writer::start_tag('fieldset', array('action' => 'invisiblefieldset'));

                // Input.
                $inputoptions = array('id' => 'searchform_search', 'name' => 'q', 'class' => 'form-control mb-2 mr-sm-2', 'placeholder' => get_string('search', 'search'),
                    'type' => 'text', 'size' => '15');
                $this->content->text .= html_writer::empty_tag('input', $inputoptions);

                // Context id.
                if ($this->page->context && $this->page->context->contextlevel !== CONTEXT_SYSTEM) {
                    $this->content->text .= html_writer::empty_tag('input', ['type' => 'hidden',
                            'name' => 'context', 'value' => $this->page->context->id]);
                }

                $this->content->text .= '<button type="submit" class="btn btn-primary mb-2"><span class="flaticon-magnifying-glass"></span></button>';
                $this->content->text .= html_writer::end_tag('fieldset');
                $this->content->text .= html_writer::end_tag('form');
                // End Search form

$this->content->text .='</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Video Section Ends Here-->
<div class="top_courses_iconbox">
  <div class="container">
    <div class="row row_home4">
      <div class="col-sm-6 col-lg-3">
        <div class="home_icon_box home4">
          <div class="icon ccn_icon_2"><span class="'.format_text($data->feature_1_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>
          <p>'.format_text($data->feature_1_title, FORMAT_HTML, array('filter' => true)).'</p>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="home_icon_box home4">
          <div class="icon ccn_icon_2"><span class="'.format_text($data->feature_2_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>
          <p>'.format_text($data->feature_2_title, FORMAT_HTML, array('filter' => true)).'</p>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="home_icon_box home4">
          <div class="icon ccn_icon_2"><span class="'.format_text($data->feature_3_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>
          <p>'.format_text($data->feature_3_title, FORMAT_HTML, array('filter' => true)).'</p>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="home_icon_box home4">
          <div class="icon ccn_icon_2"><span class="'.format_text($data->feature_4_icon, FORMAT_HTML, array('filter' => true)).'"></span></div>
          <p>'.format_text($data->feature_4_title, FORMAT_HTML, array('filter' => true)).'</p>
        </div>
      </div>
    </div>
  </div>
</div>';

}


        return $this->content;
    }

    /**
     * Serialize and store config data
     */
    function instance_config_save($data, $nolongerused = false) {
        global $CFG;

        $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                    'subdirs'       => 0,
                                    'maxfiles'      => 1,
                                    'accepted_types' => array('.jpg', '.png', '.gif'));

        for($i = 1; $i <= $data->slidesnumber; $i++) {
            $field = 'file_slide' . $i;
            if (!isset($data->$field)) {
                continue;
            }

            file_save_draft_area_files($data->$field, $this->context->id, 'block_cocoon_hero_3', 'slides', $i, $filemanageroptions);
        }

        parent::instance_config_save($data, $nolongerused);
    }

    /**
     * When a block instance is deleted.
     */
    function instance_delete() {
        global $DB;
        $fs = get_file_storage();
        $fs->delete_area_files($this->context->id, 'block_cocoon_hero_3');
        return true;
    }

    /**
     * Copy any block-specific data when copying to a new block instance.
     * @param int $fromid the id number of the block instance to copy from
     * @return boolean
     */
    public function instance_copy($fromid) {
        global $CFG;

        $fromcontext = context_block::instance($fromid);
        $fs = get_file_storage();

        if (!empty($this->config) && is_object($this->config)) {
            $data = $this->config;
            $data->slidesnumber = is_numeric($data->slidesnumber) ? (int)$data->slidesnumber : 0;
        } else {
            $data = new stdClass();
            $data->slidesnumber = 0;
        }

        $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                    'subdirs'       => 0,
                                    'maxfiles'      => 1,
                                    'accepted_types' => array('.jpg', '.png', '.gif'));

        for($i = 1; $i <= $data->slidesnumber; $i++) {
            $field = 'file_slide' . $i;
            if (!isset($data->$field)) {
                continue;
            }

            // This extra check if file area is empty adds one query if it is not empty but saves several if it is.
            if (!$fs->is_area_empty($fromcontext->id, 'block_cocoon_hero_3', 'slides', $i, false)) {
                $draftitemid = 0;
                file_prepare_draft_area($draftitemid, $fromcontext->id, 'block_cocoon_hero_3', 'slides', $i, $filemanageroptions);
                file_save_draft_area_files($draftitemid, $this->context->id, 'block_cocoon_hero_3', 'slides', $i, $filemanageroptions);
            }
        }

        return true;
    }

    /**
     * The block should only be dockable when the title of the block is not empty
     * and when parent allows docking.
     *
     * @return bool
     */
    public function instance_can_be_docked() {
        return (!empty($this->config->title) && parent::instance_can_be_docked());
    }

}
