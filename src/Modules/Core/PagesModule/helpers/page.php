<?php

function parse_page_content($content, $id, $with_editor = true)
{
    if($with_editor === false) {
        return $content;
    }
    return parse_content_for_admin_frontend_editor($content, $id);
}

function parse_content_for_admin_frontend_editor($content, $id)
{
    $User = Auth::user();

    if ($User === null) {
        return $content;
    }

    if ((userCanTranslate($User) === true) && (translateEnabled())) {
        $wrapper_div = "<trans class='page-editor-element' id='{$id}'>{$content}</trans>";
        
        return $wrapper_div;
    } else {
        return $content;
    }
}

