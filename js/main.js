(function($) {
    $(document).ready(function() {
        if($("#disable_argbox_status").is(":checked")) {
            $("#box_width").parents('tr').addClass('hidden');
        }

        $("#enable_argbox_status").on('click' , function() {
            $("#app_id, #box_width, #title").attr("readonly", false);
            $("#displays_in , #lang , #no_title").attr("disabled", false);
            $("#box_width")
            .parents('tr')
            .add('.speakol-info')
            .add('#speakol_shortcode')
            .removeClass('hidden');
        });
        $("#disable_argbox_status").on('click' , function() {
            $("#app_id, #box_width, #title").attr("readonly", true);
            $("#displays_in, #lang, #no_title").attr("disabled", true);
            $("#box_width")
            .parents('tr')
            .add('.speakol-info')
            .add('#speakol_shortcode')
            .addClass('hidden');
        });

        $("#displays_in").on('change', function() {
            $("input[name='speakol_displays_in']").val($("#displays_in").val());
        });

        $("#lang").on('change', function() {
            $("input[name='speakol_lang']").val($("#lang").val());
        });
    });
})(jQuery);
