<?php
global $CFG;

class block_cocoon_hero_1 extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_hero_1', 'block_cocoon_hero_1');
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
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_hero_1', 'content');
        $this->content->image = '';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image .=  $url;
            }
        }



        $this->content->text = '
        <section class="home-three home3-overlay home3_bgi6" style="background-image:url('.$url.');background-size:cover;">
      		<div class="container">
      			<div class="row posr">
      				<div class="col-lg-12">
      					<div class="home-text text-center">
      						<h2 class="fz50">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h2>
      						<p class="color-white">'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
      						<a class="btn home_btn" href="'.format_text($this->content->button_link, FORMAT_HTML, array('filter' => true)).'">'.format_text($this->content->button_text, FORMAT_HTML, array('filter' => true)).'</a>
      					</div>
      				</div>
      			</div>
      			<div class="row_style">
      				<svg class="waves" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 300" preserveAspectRatio="none"> <path d="M 1000 280 l 2 -253 c -155 -36 -310 135 -415 164 c -102.64 28.35 -149 -32 -235 -31 c -80 1 -142 53 -229 80 c -65.54 20.34 -101 15 -126 11.61 v 54.39 z"></path><path d="M 1000 261 l 2 -222 c -157 -43 -312 144 -405 178 c -101.11 33.38 -159 -47 -242 -46 c -80 1 -153.09 54.07 -229 87 c -65.21 25.59 -104.07 16.72 -126 16.61 v 22.39 z"></path><path d="M 1000 296 l 1 -230.29 c -217 -12.71 -300.47 129.15 -404 156.29 c -103 27 -174 -30 -257 -29 c -80 1 -130.09 37.07 -214 70 c -61.23 24 -108 15.61 -126 10.61 v 22.39 z"></path></svg>
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
