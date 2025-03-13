<?php
namespace INITP\OptionPageBuilder\Classes;

defined( 'ABSPATH' ) || exit;

use INITP\OptionPageBuilder\Classes\Log;

class Field
{ 
        private array $args;
        private string $id;
        private string $class;
        private string $readonly;
        private string $name;
        private array $field_options;
        private mixed $current_value;
        private string $desc;

    function __construct( $args )
    {
        $this->args = $args;
        $this->id = $args['label_for'];
        $this->class = isset( $args['class'] ) ? 'class="' . $args['class'] . '"' : '';
        $this->readonly = isset( $args['readonly'] ) &&  $args['readonly'] === true ? 'readonly' : '';
        $this->name = $args['option_name'] . '[' . $this->id . ']';
        $this->field_options = isset( $args['field_options'] ) ? $args['field_options'] : [ 'No Field Options' => 'No Field Options'];
        $options = get_option( $args['option_name'] );
        $this->current_value = isset($options[$this->id]) ? $options[$this->id] : '';
        $this->desc = isset( $args['desc'] ) ? '<p class="description">' . $args['desc'] . '</p>' : '';
    }

    public function render( $callback )
    {
        if ( method_exists($this, $callback) ) 
        {
            return $this->{$callback}();
        }

        return '<p>Invalid field callback: ' . $callback . '</p>';
    }

    private function text()
    {
        ?>

        <input id="<?php echo $this->id; ?>" 
            <?php echo $this->class;?> 
            name="<?php echo $this->name; ?>" 
            type="text" 
            value="<?php echo esc_attr($this->current_value); ?>">
        <?php echo $this->desc; ?>

        <?php
    } // method close

    private function textInfo()
    {
        $placeholder_value = '';

        switch( true )
        {
            case isset($this->args['constant']):
                $placeholder_value = defined($this->args['constant']) ? constant($this->args['constant']) : 'Undefined';
                break;

        }

        // Check if the value needs to be masked
        if( 
            $placeholder_value !== '' && 
            $placeholder_value !== 'Undefined' &&
            !empty( $this->args['mask'] )
        ){
            $placeholder_value = str_repeat('*', strlen($placeholder_value));
        }

        ?>

        <input <?php echo $this->class;?> 
            type="text"
            placeholder="<?php echo esc_attr($placeholder_value); ?>"
            <?php echo $this->readonly; ?>>
        <?php echo $this->desc; ?>

        <?php
    } // method close

    private function email()
    {
        ?>

        <input id="<?php echo $this->id; ?>" 
            <?php echo $this->class;?> 
            name="<?php echo $this->name; ?>" 
            type="email" 
            value="<?php echo esc_attr($this->current_value); ?>"
            <?php echo $this->readonly; ?>>
        <?php echo $this->desc; ?>

        <?php
    } // method close
     

    private function number() 
    {
        // Prepare output
        $min = isset( $this->args['min'] ) ? 'min="' . $this->args['min'] . '"' : '';
        $max = isset( $this->args['max'] ) ? 'max="' . $this->args['max'] . '"' : '';      
        ?>

        <input id="<?php echo $this->id; ?>" 
            <?php echo $this->class;?> 
            name="<?php echo $this->name; ?>" 
            type="number" 
            value="<?php echo esc_attr($this->current_value); ?>"
            <?php echo $min; ?>
            <?php echo $max; ?>
            <?php echo $this->readonly; ?>>
        <?php echo $this->desc; ?>

        <?php
    } // method close
     
    private function textarea() 
    {
        ?>
        
        <textarea id="<?php echo $this->id; ?>" 
            <?php echo $this->class; ?> 
            name="<?php echo $this->name; ?>" 
            rows="15"
            <?php echo $this->readonly; ?>><?php echo esc_textarea($this->current_value); ?></textarea>
        <?php echo $this->desc; ?>

        <?php
    } // method close

     
    private function select() 
    {
        ?>
        <select id="<?php echo $this->id; ?>" 
            <?php echo $this->class; ?> 
            name="<?php echo $this->name; ?>"
            <?php echo $this->readonly; ?>>
                <?php foreach( $this->field_options as $value => $display_value ): ?>
                    <option value="<?php echo $value;?>" <?php echo selected( $value, esc_attr($this->current_value), false ); ?>><?php echo $display_value;?></option>
                <?php endforeach; ?>
        </select>
        <?php echo $this->desc; ?>

        <?php
    } // method close
 
     
    private function radio()
    {
        $i = 0;

        foreach ( $this->field_options as $value => $display_value ):
            $i++;
            $id_for = $this->id . "-$i"; // unique value for 'id' and 'for' matching
            ?>
            <p>
                <input id="<?php echo $id_for; ?>" 
                    <?php echo $this->class; ?>
                    type="radio" 
                    name="<?php echo $this->name; ?>"
                    value="<?php echo $value; ?>"
                    <?php echo checked( $value, esc_attr($this->current_value), false );?>>
                <label for="<?php echo $id_for; ?>"><?php echo $display_value; ?></label>
            </p>
        <?php endforeach; ?>
        <?php echo $this->desc; ?>

        <?php

    } // method close

    private function checkbox()
    {
        // Checkbox handles some properties different to other fields
        // to support a multiple selection array.
        $current_value = $this->current_value;

        $name = $this->name . '[]'; // Always an array
        $i = 0;

        // Output a hidden input to ensure when all boxes are unchecked
        // the stored value is updated to empty correctly.
        ?>
        <input type="hidden" name="<?php echo $name; ?>" value="">
        <?php

        //wpdd( $current_value );
        foreach ($this->field_options as $value => $display_value)
        {
            $i++;
            $id_for = $this->id . "-$i"; // unique value for 'id' and 'for' matching
            
            // Determine if checkbox should be checked
            $is_checked = is_array($current_value) ? in_array( $value, $current_value ) : false;

            ?>
            <p>
                <input id="<?php echo esc_attr($id_for); ?>" 
                    <?php echo $this->class; ?>
                    type="checkbox" 
                    name="<?php echo $name; ?>"
                    value="<?php echo esc_attr($value); ?>"
                    <?php echo checked($is_checked, true); ?>>
                <label for="<?php echo esc_attr($id_for); ?>"><?php echo esc_html($display_value); ?></label>
            </p>
            <?php
        }
    
        echo $this->desc;
    } // method close
    
    
    
} // class close