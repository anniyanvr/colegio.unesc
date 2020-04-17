<?php

class block_cocoon_course_list_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title
        $mform->addElement('text', 'config_title', get_string('config_title', 'theme_edumy'));
        $mform->setDefault('config_title', 'Category Filter');
        $mform->setType('config_title', PARAM_RAW);

    }

}
