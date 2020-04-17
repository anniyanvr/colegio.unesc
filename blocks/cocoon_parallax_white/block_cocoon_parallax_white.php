<?php
global $CFG;

class block_cocoon_parallax_white extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_parallax_white', 'block_cocoon_parallax_white');
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
        if(!empty($this->config->subtitle)){$this->content->subtitle = $this->config->subtitle;}
        if(!empty($this->config->button_link)){$this->content->button_link = $this->config->button_link;}
        if(!empty($this->config->button_text)){$this->content->button_text = $this->config->button_text;}
        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_parallax_white', 'content');
        $this->content->image = '';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image .=  $url;
            }
        }



        $this->content->text = '
        <section class="home3_about2 pb40 pt20">
      		<div class="container">
      			<div class="row">
      				<div class="col-lg-5">
      					<div class="about2_home3">
      						<h3>'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
      						<p>'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
      						<a href="'.format_text($this->content->button_link, FORMAT_HTML, array('filter' => true)).'" class="btn about_btn_home3">'.format_text($this->content->button_text, FORMAT_HTML, array('filter' => true)).'</a>
      					</div>
      				</div>
      				<div class="col-lg-7">
      					<div class="about_thumb_home3 text-right">
      						<img class="img-fluid" src="'.$this->content->image.'" alt="">
      					</div>
      				</div>
      			</div>
      			<div class="row">
      				<div class="col-lg-12">
      					<div class="about_home3_shape_container">
      						<div class="about_home3_shape3"><img src="'.$CFG->wwwroot.'/theme/edumy/images/about/shape3.png" alt=""></div>
      					</div>
      				</div>
      			</div>
      		</div>
      	</section>';
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
