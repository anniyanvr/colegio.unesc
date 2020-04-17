<?php
global $CFG;

class block_cocoon_about_1 extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_about_1', 'block_cocoon_about_1');
    }

    // Declare second
    public function specialization()
    {
        $this->title = isset($this->config->title) ? format_string($this->config->title) : '';
    }
    public function get_content(){
        global $CFG, $DB;
        require_once($CFG->libdir . '/filelib.php');
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content         =  new stdClass;
        if(!empty($this->config->title)){$this->content->title = $this->config->title;}
        if(!empty($this->config->body)){$this->content->body = $this->config->body['text'];}
        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_about_1', 'content');
        $this->content->image = '';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image .=  $url;
            }
        }

        $this->content->text = '
<div class="container mt80">
        <div class="row">
        				<div class="col-lg-6">
        					<div class="about_content">
        						<h3>'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
        						'.format_text($this->content->body, FORMAT_HTML, array('filter' => true)).'
        					</div>
        				</div>
        				<div class="col-lg-6">
        					<div class="about_thumb">
        						<img class="img-fluid" src="'.$this->content->image.'" alt="'.$filename.'">
        					</div>
        				</div>
        			</div>
              </div>
';
        return $this->content;
    }

    /**
     * Allow multiple instances in a single course?
     *
     * @return bool True if multiple instances are allowed, false otherwise.
     */
    public function instance_allow_multiple() {
        return true;
    }

    /**
     * Enables global configuration of the block in settings.php.
     *
     * @return bool True if the global configuration is enabled.
     */
    function has_config() {
        return true;
    }

    /**
     * Sets the applicable formats for the block.
     *
     * @return string[] Array of pages and permissions.
     */
     function applicable_formats() {
         return array(
           'all' => true,
           'my' => false,
         );
     }

}
