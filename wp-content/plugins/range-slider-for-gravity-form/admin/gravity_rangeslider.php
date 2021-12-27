<?php
class OC_GF_Field_Rangeslider extends GF_Field {

    public $type = 'Rangeslider';

    public function get_form_editor_field_title() { return esc_attr__( 'Rangeslider', 'gravityforms' ); }

    public function get_form_editor_button() {
        return array(
            'group' => 'advanced_fields',
            'text'  => $this->get_form_editor_field_title(),
            'onclick'   => "StartAddField('".$this->type."');",
        );
    }
    function get_form_editor_field_settings() {
        return array(
            'label_setting',
            'description_setting',
            'slider_range',
            'Prefixvalue',
            'slider_position',
            'stepvalue',
            'slider_show',
            'range_show',
            'slider_styling',
            'slider_label',
            'slider_value_visibility',
            'label_placement_setting',
            'css_class_setting',
            'admin_label_setting',
            'default_value_setting',
            'visibility_setting',
            'prepopulate_field_setting',
            'conditional_logic_field_setting'           
        );
    }
    function is_conditional_logic_supported() { return true; }

    function get_value_submission( $field_values, $get_from_post=true ) {
            if(!$get_from_post) {
                return $field_values;
            }
        return $_POST;
    } 
     function get_field_input( $form, $value = '', $entry = null ) {
        $is_entry_detail = $this->is_entry_detail();
        $is_form_editor  = $this->is_form_editor();
        $form_id  = $form['id'];
        $id       = intval( $this->id );
        $field_id = $is_entry_detail || $is_form_editor || $form_id == 0 ? "input_$id" : 'input_' . $form_id . "_$id";
        $atts['type'] = 'hidden';
        $size          = $this->size;
        $disabled_text = $is_form_editor ? "disabled='disabled'" : '';
        $class_suffix  = $is_entry_detail ? '_admin' : '';
        $class         = $this->type . ' ' .$size . $class_suffix;
        $instruction = '';
        $read_only   = '';
        $atts['Prefixvalue'] = $this->Prefixvalue;
        $atts['slider_show'] = $this->slider_show;
        $atts['range_show'] = $this->range_show;
        $atts['slider_styling'] = $this->slider_styling;
        $atts['min'] = $this->min;
        $atts['max'] = $this->max;
        $atts['slider_label']= $this->slider_label;
        $atts['slider_position'] = $this->slider_position;  
        $atts['stepvalue'] = $this->stepvalue;       


            if($atts['slider_styling']=="circles"){
                $class_name = "circles-slider";
               
            }else if($atts['slider_styling']=="scale"){
                $class_name = "scale-slider";
                 
            }else if($atts['slider_styling']=="rainbow"){ 
                $class_name = "rainbow-slider";
                   
            }else if($atts['slider_styling']=="modern_flat"){ 
                $class_name = "flat-slider";

            }else if($atts['slider_styling']=="double_labels"){ 
                $class_name = "double-label-slider";

            }else{
                $class_name = "slider-display";
            }
            
            $ocgr = "<div class='ginput_container'><div class='".$class_name."'   sliderposition='".$atts['slider_position']."'  step='".$atts['stepvalue']."'  prefix='".$atts['Prefixvalue']."'   slidershow='".$atts['slider_show']."' rangeshow='".$atts['range_show']."'  min='".$atts['min']."'  max='".$atts['max']."' label='".$atts['slider_label']."' ><input  name='input_".$id."'  id=". $form_id." type=".$atts['type']."  /></div></div>";

          return $ocgr;
     }
}
GF_Fields::register(new OC_GF_Field_Rangeslider() );


add_action( 'gform_field_standard_settings', 'wdm_gf_add_custom_field' , 10,  2);
function wdm_gf_add_custom_field( $position, $form_id )
 {      
        // retrieve the data earlier stored in the database or create it
        if ($position == 50) {
            ?> 
            <li class="slider_range field_setting">
                <label for="slider_range" class="section_label">
                       <?php esc_html_e('Range', 'gravityforms'); ?>
                </label>
                <?php esc_html_e('min', 'gravityforms'); ?>
                <input type="number" id="slider_range_min"  name="min" min="1"  onchange="SetFieldProperty('min', this.value);" /></br>
                <?php esc_html_e('max', 'gravityforms'); ?>
                <input type="number" id="slider_range_max"  name="max" min="1"  onchange="SetFieldProperty('max', this.value);"/>
            </li>
            <li class="Prefixvalue field_setting">
                <label for="Prefixvalue" class="section_label">
                       <?php esc_html_e('Prefix', 'gravityforms'); ?>
                </label>
                <input type="text" name="prefix" id="Prefixvalue"  onchange="SetFieldProperty('Prefixvalue', this.value);" />
            </li>
            <li class="slider_position field_setting">
                <label for="slider_position" class="section_label">
                       <?php esc_html_e('prefix position :', 'gravityforms'); ?>
                </label>
                <?php esc_html_e('Left', 'gravityforms'); ?>
                <input type="radio"  class="gf_rs_radio" name="slider_position" value="left"  checked="checked" onchange="SetFieldProperty('slider_position', this.value);" disabled=""/>
                <?php esc_html_e('Right', 'gravityforms'); ?>
                <input type="radio"  class="gf_rs_radio"   name="slider_position" value="right" onchange="SetFieldProperty('slider_position', this.value); " disabled=""/>
                <label class="ocgfrs_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/range-slider-for-gravity-forms-pro/" target="_blank">link</a></label>
            </li>
            <li class="stepvalue field_setting">
                <label for="stepvalue" class="section_label">
                    <?php esc_html_e('Step :', 'gravityforms'); ?>
                </label>
                <input type="number" id="stepvalue"  name="stepvalue"  onchange="SetFieldProperty('stepvalue', this.value);"/>
            </li>
            <li class="slider_show field_setting">
                <label for="slider_show" class="section_label">
                       <?php esc_html_e('slider display :', 'gravityforms'); ?>
                </label>
                <?php esc_html_e('Single Edge Slider', 'gravityforms'); ?>
                <input type="radio"  class="gf_rs_radio"  name="sliderdisplay" checked="checked" value="single_slider"   onchange="SetFieldProperty('slider_show', this.value);" disabled=""/>
                <?php esc_html_e('Double Edge Slider', 'gravityforms'); ?>
                <input type="radio"  class="gf_rs_radio"  name="sliderdisplay" value="double_slider"  onchange="SetFieldProperty('slider_show', this.value);" disabled=""/>
                <label class="ocgfrs_pro_link">Only available in pro version <a href="https://www.xeeshop.com/product/range-slider-for-gravity-forms-pro/" target="_blank">link</a></label>
            </li>
            <li class="slider_styling field_setting">
                <label for="slider_styling" class="section_label">
                       <?php esc_html_e('Slider Styling :', 'gravityforms'); ?>
                </label>
                <ul class="ocrsg_display_ul">
                     <li>
                        <?php esc_html_e('Simple', 'gravityforms'); ?>
                        <input type="radio"  class="gf_rs_radio" name="style_slide" value="Simple"  onchange="SetFieldProperty('slider_styling', this.value);"/>
                    </li>
                    <li>
                        <?php esc_html_e('Circles', 'gravityforms'); ?>
                        <input type="radio"  class="gf_rs_radio" name="style_slide" value="circles"   onchange="SetFieldProperty('slider_styling', this.value);"/>
                    </li>
                </ul>
                <ul class="ocrsg_display_ul">
                    <li>
                      <?php esc_html_e('Scale', 'gravityforms'); ?>
                        <input type="radio"  class="gf_rs_radio" name="style_slide" value="scale"  onchange="SetFieldProperty('slider_styling', this.value);"/>
                    </li>
                    <li>
                      <?php esc_html_e('Rainbow', 'gravityforms'); ?>
                        <input type="radio"  class="gf_rs_radio" name="style_slide" value="rainbow"  onchange="SetFieldProperty('slider_styling', this.value);"/>
                    </li>
                </ul>
                <ul class="ocrsg_display_ul">
                    <li>
                      <?php esc_html_e('Modern Flat', 'gravityforms'); ?>
                        <input type="radio"  class="gf_rs_radio" name="style_slide" value="modern_flat"  onchange="SetFieldProperty('slider_styling', this.value);"/>
                    </li>
                    <li>
                     <?php esc_html_e('Double Labels', 'gravityforms'); ?>
                        <input type="radio"  class="gf_rs_radio" name="style_slide" value="double_labels"  onchange="SetFieldProperty('slider_styling', this.value);"/>
                    </li>
                </ul>
            </li>
            <li class="range_show field_setting">
                <label for="range_show" class="section_label">
                       <?php esc_html_e('range show :', 'gravityforms'); ?>
                </label>
                <?php esc_html_e('Enable', 'gravityforms'); ?>
                <input type="radio"  class="gf_rs_radio" name="rangeshow" value="enable"   onchange="SetFieldProperty('range_show', this.value);"/>
                <?php esc_html_e('Disable', 'gravityforms'); ?>
                <input type="radio"  class="gf_rs_radio" name="rangeshow" value="disable"  onchange="SetFieldProperty('range_show', this.value);"/>
            </li>
            <li class="slider_label field_setting">
                <label for="slider_label" class="section_label">
                       <?php esc_html_e('Slider label :', 'gravityforms'); ?>
                </label>
                <input type="input" id="slider_label"  name="slider_label"  onchange="SetFieldProperty('slider_label', this.value);" />
                <p>[<strong>NOTE:</strong>if you add label and range-show enable so show label otherwise show range.and label add <strong>(ex: sunday,monday,tuseday)</strong> use to comma.]</p>
            </li>
            
            <?php 
    }      
}

add_action('gform_editor_js', 'wdm_editor_script', 11, 2);
function wdm_editor_script() {
    ?>
    <script type='text/javascript'>
        jQuery(document).ready(function($) {
            jQuery(document).bind("gform_load_field_settings", function(event, field, form){
                jQuery("#slider_range_min").val(field["min"]);
                jQuery("#slider_range_max").val(field["max"]);
                jQuery("#slider_label").val(field["slider_label"]);
                jQuery("#Prefixvalue").val(field["Prefixvalue"]);
                jQuery("input[name=slider_position][value='left']").prop('checked', true);
                jQuery("#stepvalue").val(field["stepvalue"]);
                jQuery("input[name=sliderdisplay][value='single_slider']").prop('checked', true);
                jQuery("input[name=rangeshow][value=" + field["range_show"] + "]").prop('checked', true);
                jQuery("input[name=style_slide][value=" + field["slider_styling"] + "]").prop('checked', true);
            });
        });
    </script>
    <?php
}

add_action( 'gform_editor_js_set_default_values', 'OCRSGF_set_default_values' );
function OCRSGF_set_default_values(){
    ?>
    case "Rangeslider" :
        field.label = 'Range Slider';
        field.min = 1;
        field.max = 23;
        field.stepvalue = 4;
        field.Prefixvalue = '%';
        field.slider_position = 'right';
        field.slider_show = 'double_slider';
        field.range_show = 'enable';
        field.slider_styling = 'scale';
    break;
    
    <?php
}
