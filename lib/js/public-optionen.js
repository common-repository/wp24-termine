/*jshint esversion: 6 */
jQuery(document).ready(function($) {

  //$(".dropdown").css('position', 'absolute');

  $(document).on('click', '.select-event', function() {
    $("#apd-kursplan").remove();
    var id = $(this).attr('data-id');
    var group_id = $(this).attr('data-group_id');
    load_events(id, 'get_category', group_id);
  });

  function load_events(id = "", method = "", group_id = "") {
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgNoAdmin',
      method: method,
      id: id,
      group_id: group_id
    }, function(data) {
      if (data.status) {
        var html = '';
        var background = '';
        var color = '';
        var termin_content = '';
        var time = '';
        var out_color = '';
        var hover_color = '';
        var leer_class = '';
        var show_day = '';
        var href_start = '';
        var href_end = '';
        var info_icon = '';
        var cursor = 'default';
        html += '<div id="apd-kursplan">';
        html += '<div class="kp-grid">';

        $.each(data.events, function(key, val) {
          if (val.result) {
            show_day = '';
          } else {
            show_day = ' kp-leer';
          }
          html += '<div class="grid-item">';
          html += '<div class="box-header ' + show_day + '" style="background:' + data.settings.bg_day + ';color:' + data.settings.color_day + ';">';
          html += '<div class="kp-day" style="font-size:' + data.settings.font_size_week + 'px";>';
          html += val.day;
          html += '</div><!--day-->';
          html += '</div><!--header-->';
          //BOXEN
          if (!val.result) {
            background = data.settings.bg_leer;
            color = data.settings.color_day;
            termin_content = '';
            time = '';
            hover_color = data.settings.bg_leer;
            out_color = data.settings.bg_leer;
            leer_class = 'kp-leer';

            html += '<div style="background: ' + background + '; color:' + color + ';min-height:' + data.settings.min_height + 'px;"';
            html += 'onmouseover="this.style.background=\'' + hover_color + '\';"';
            html += 'onmouseout="this.style.background=\'' + out_color + '\';" class="kp-content ' + leer_class + '">';
            html += '<div class="kp-content-head" style="font-size:' + data.settings.font_size_content + 'px;">';
            html += termin_content;
            html += '</div>';
            html += '<div class="content-time" style="font-size:' + data.settings.font_size_time + 'px;">';
            html += time;
            html += '</div>';
            html += '</div>';
          }

          $.each(val.event, function(key, tmp) {
            if (tmp.leer == '1') {
              background = data.settings.bg_leer;
              color = data.settings.color_day;
              termin_content = '';
              time = '';
              hover_color = data.settings.bg_leer;
              out_color = data.settings.bg_leer;
              leer_class = 'kp-leer';
            } else {
              background = tmp.bg_color;
              color = tmp.txt_color;
              termin_content = tmp.content;
              time = tmp.time_von + ' - ' + tmp.time_bis;
              hover_color = tmp.hover_color;
              out_color = tmp.bg_color;
              leer_class = '';
            }

            if (tmp.post_site == '1') {
              href_start = '<a title="' + tmp.post_title + '" href="' + data.site_url + 'apd-termin-plan/' + tmp.post_name + '">';
              href_end = '</a>';
              cursor = 'pointer';
              info_icon = '<small><i class="small-info-icon fa fa-globe"></i></small>';
            } else {
              href_start = '';
              href_end = '';
              info_icon = '';
              cursor = 'default';
            }
            html += href_start + '<div style="cursor:' + cursor + ';background: ' + background + '; color:' + color + ';min-height:' + data.settings.min_height + 'px;"';
            html += 'onmouseover="this.style.background=\'' + hover_color + '\';"';
            html += 'onmouseout="this.style.background=\'' + out_color + '\';" class="kp-content ' + leer_class + '">';
            html += '<div class="kp-content-head" style="font-size:' + data.settings.font_size_content + 'px;">';
            html += termin_content;
            html += '</div>';
            html += '<div class="content-time" style="font-size:' + data.settings.font_size_time + 'px;">';
            html += time + info_icon;
            html += '</div>';
            html += '</div>';
            html += href_end;
          });
          html += '</div><!--item-->';
        });
        html += '</div>';
        html += '</div>';
        $("#apd-kursplan").hide();
        $("#show-ajax-event").html(html);
      }
    });
  }
});
