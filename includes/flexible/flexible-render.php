<?php

if (have_rows('flex_sections')):

    while (have_rows('flex_sections')): the_row();

        $layout = get_row_layout();

        $path = 'includes/flexible/layouts/' . $layout . '/' . $layout;

        if (locate_template($path . '.php')) {
            get_template_part($path);
        }

    endwhile;

endif;