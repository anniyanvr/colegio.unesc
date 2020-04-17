<?php
global $CFG;

class block_cocoon_subscribe extends block_base
{
    // Declare first
    public function init()
    {
        $this->title = get_string('cocoon_subscribe', 'block_cocoon_subscribe');
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
        if(!empty($this->config->button_text)){$this->content->button_text = $this->config->button_text;}

        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_cocoon_subscribe', 'content');
        $this->content->image = '';
        foreach ($files as $file) {
            $filename = $file->get_filename();
            if ($filename <> '.') {
                $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
                $this->content->image .=  $url;
            }
        }



        $this->content->text = '
        <section id="our-newslatters" class="our-newslatters">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="main-title text-center">
          <h3 class="mt0">'.format_text($this->content->title, FORMAT_HTML, array('filter' => true)).'</h3>
          <p>'.format_text($this->content->subtitle, FORMAT_HTML, array('filter' => true)).'</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="footer_apps_widget_home1">
          <form action="'.$CFG->wwwroot.'/local/contact/index.php" method="post" class="form-inline mailchimp_form">

                <input id="email" name="email" type="email" required="required" class="form-control" placeholder="'.get_string('email_address', 'theme_edumy').'">
                <input type="hidden" id="sesskey" name="sesskey" value="">
                <script>document.getElementById(\'sesskey\').value = M.cfg.sesskey;</script>
                <button type="submit" name="submit" id="submit" class="btn btn-lg btn-thm dbxshad">'.format_text($this->content->button_text, FORMAT_HTML, array('filter' => true)).' <span class="flaticon-right-arrow-1"></span></button>

          </form>




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
