<?php

add_filter(
    'register_block_type_args',
    function ($args, $name) {
        if ($name === 'core/buttons') {
            $args['render_callback'] = function ($attributes, $content) {
                return view('blocks/buttons', compact('attributes', 'content'));
            };
        }

        return $args;
    },
    10,
    2,
);
