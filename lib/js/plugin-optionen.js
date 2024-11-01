/*jshint esversion: 6 */
jQuery(document).ready(function($) {

  /*+++++++++++++++++++++++++++++++++++
  ++++++++ DATA TANLE Optionen ++++++++
  +++++++++++++++++++++++++++++++++++++
  */
  $('#StartTable').DataTable({
    columnDefs: [{
      targets: '_all',
      className: 'dt-head-left'
    }]
  });

  $('#WeekdaysTable').DataTable({
    columnDefs: [{
      targets: '_all',
      className: 'dt-head-left'
    }]
  });

  $('#GroupTable').DataTable({
    columnDefs: [{
      targets: '_all',
      className: 'dt-head-left'
    }]
  });

  $('#SeitenTable').DataTable({
    "columns": [
      null,
      null,
      null,
      null,
      null,
      null,
      {
        "width": "5%"
      },
      {
        "width": "5%"
      },
      {
        "width": "5%"
      },
    ],
    columnDefs: [{
      targets: '_all',
      className: 'dt-head-left'
    }]
  });

  $('#CategoryTable').DataTable({
    columnDefs: [{
      targets: '_all',
      className: 'dt-head-left'
    }],
    "pageLength": 100
  });

  /*+++++++++++++++++++++++++++++++++
  ++++++++ BOXEN SHOW & HIDE ++++++++
  +++++++++++++++++++++++++++++++++++
  */

  $(document).on('click', '.btn-add-sites', function() {
    $("#show-kategorie-seite").hide();
    $("#add_site").show(400);
  });

  $(document).on('click', '.btn-add-settings', function() {
    $("#tableSettings").hide();
    $("#add_settings").show(400);
  });

  $(document).on('click', '.btn-add-weekdays', function() {
    $("#table-weekdays").hide();
    $("#add_weekdays").show(400);
  });

  $(document).on('click', '.btn-add-category', function() {
    $("#table-kategorie").hide();
    $("#add_category").show(400);
  });

  $(document).on('click', '.btn-add-eintrag', function() {
    $("#show_events").hide();
    $("#dropdown-settings").hide();
    $("#add_eintrag").show(400);
  });

  $(document).on('click', '.btn-dropdown-settings', function() {
    $("#show_events").hide();
    $("#add_eintrag").hide();
    $("#dropdown-settings").show(400);
  });

  $(document).on('click', '.btn-return, .btn-close', function() {
    $("#weekdays-form").trigger("reset");
    $("#add_standard_settings").trigger("reset");
    $("#add_settings").hide();
    $("#add_weekdays").hide();
    $("#add_category").hide();
    $("#add_eintrag").hide();
    $("#edit-event").hide();
    $("#dropdown-settings").hide();
    $("#add_site").hide();
    $("#table-weekdays").show(400);
    $("#tableSettings").show(400);
    $("#table-kategorie").show(400);
    $("#show_events").show(400);
    $("#show-kategorie-seite").show(400);
  });

  $(document).on('click', '.btn-close-group', function() {
    $("#apd-add-group").trigger("reset");
    $("#show_add_group").hide();
    $("#show_groups").show(400);
  });

  $(document).on('click', '.btn-add-terminplan', function() {
    $("#show_groups").hide();
    $("#show_add_group").show(400);
  });

  $(document).on('click', '.edit-termine', function() {
    $("#show_groups").hide();
    $("#show_add_group").show(400);
  });

  /*+++++++++++++++++++++++++++++++++++++
  ++++++++ TOGGLE ALL CATEGORY +++++++++
  +++++++++++++++++++++++++++++++++++++++
  */
  /*$('#toggle-selected').toggle(
        function () {
            $(".select-category").prop("checked", true);
        },
        function () {
            $('.select-category').removeAttr('checked');
        }
    );
    */

    $(document).on('click', '#toggle-selected', function() {
      $(".select-category").attr("checked", "checked");
    });

  /*++++++++++++++++++++++++++++++++++++++++++
  ++++++++ Deleted Selected CATEGORY +++++++++
  ++++++++++++++++++++++++++++++++++++++++++++
  */

    $(document).on('click', '.btn-delete-selected-category', function() {
      var selected = $(".select-category");
      for (var i = 0; i < selected.length; i++) {
        var select = selected[i];
        if($(select).attr('checked')){
          var id = $(select).attr('data-id');
          delete_category(id);
        }
      }
    });

  /*+++++++++++++++++++++++++++++++++++++
  ++++++++ CHANGE METABOX-SELECT ++++++++
  +++++++++++++++++++++++++++++++++++++++
  */
  $(document).on('change', '.select-meta-category', function() {
    var id = $(".select-meta-category").val();
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'if_matabox_post',
      id: id
    }, function(data) {
      if (data.status) {
        success_message(data.msg);
      } else {
        warning_message(data.msg);
      }
    });
  });


  /*+++++++++++++++++++++++++++++++++++++
  ++++++++ CHANGE GROUP EINTRÄGE ++++++++
  +++++++++++++++++++++++++++++++++++++++
  */
  $(document).on('change', '.change_group_form', function() {
    var id = $(this).attr('data-id');
    var type = $(this).attr('data-type');
    var eintrag = $(this).val();
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'update_group_settings',
      id: id,
      eintrag: eintrag,
      type: type
    }, function(data) {
      if (data.status) {
        success_message(data.msg);
      } else {
        warning_message(data.msg);
      }
    });
  });

  /*++++++++++++++++++++++++++++++
  ++++++++ LOAD DEMO PLAN ++++++++
  ++++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.btn-add-demo', function() {
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'load_demo_plan'
    }, function(data) {
      if (data.status) {
        success_message(data.msg);
        if (data.load_demo) {
          window.setTimeout(function() {
            location.reload();
          }, 2500);
        }
      } else {
        warning_message(data.msg);
      }
    });
  });

  /*+++++++++++++++++++++++++++++++++
  ++++++++ CHANGE LEER AKTIV ++++++++
  +++++++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.leer_checked', function() {
    var id = $(this).attr('data-id');
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'change_leer_aktiv',
      id: id
    }, function(data) {
      if (data.status) {
        if (data.cat_aktiv) {
          $(".cat-sel").removeAttr('disabled');
        } else {
          $(".cat-sel").attr('disabled', '');
        }
      }
    });
  });

  /*++++++++++++++++++++++++++++++++++++++++++++
  ++++++++ CHANGE SELECT KATEGORY SEITE ++++++++
  ++++++++++++++++++++++++++++++++++++++++++++++
  */
  $(document).on('change', '.seite-category-select', function() {
    var id = $(".seite-category-select").val();
    if (id == 0) {
      $("#add_category_seite").attr('disabled', "");
    } else {
      $("#add_category_seite").removeAttr('disabled');
    }
  });

  /*++++++++++++++++++++++++++++++++++
  ++++++++ CHANGE GROUP AKTIV ++++++++
  ++++++++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.change_group_aktiv', function() {
    var id = $(this).attr('data-id');
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'change_group_aktiv',
      id: id
    }, function(data) {
      if (data.status) {
        success_message(data.msg);
      } else {
        warning_message(data.msg);
      }
    });
  });

  /*++++++++++++++++++++++++++++++++++++
  ++++++++ FORMULAR AJAX METHOD ++++++++
  ++++++++++++++++++++++++++++++++++++++
  */
  $(document).on('submit', '.send-apd-settings', function() {
    var form_data = $(this).serializeObject();
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      daten: form_data
    }, function(data) {
      if (data.status) {
        success_message(data.msg);
        if (data.add_settings) {
          add_settings(data);
        }
        if (data.add_weekdays) {
          add_weekdays(data.days, data.btn_sprache);
        }
        if (data.add_category) {
          add_category(data.eintrag, data.sprache);
        }
        if (data.update_event) {
          location.reload(true);
        }
        if (data.new_eintrag) {
          location.reload();
        }
        if (data.add_group) {
          location.reload();
        }
        if(data.send_modal){
          $("#DropModal.modal-overlay").hide();
        }
        if (data.dropdown_update) {
          $("#dropdown-settings").hide();
          $("#show_events").show(400);
        }
        if (data.update_cont) {
          $("#meinModal.modal-overlay").hide();
        }
      } else {
        warning_message(data.msg);
      }
    });
    return false;
  });

  /*+++++++++++++++++++++++++++++++
  ++++++++ TABLE ADD SETTINGS  ++++++++
  +++++++++++++++++++++++++++++++++
  */
  function add_settings(data) {
    var t = $('#StartTable').DataTable();
    var newTableRow = '';

    $(".select-settings").append('<option value="' + data.id + '">' + data.name + '</option>');

    t.row.add([
      newTableRow + '<b><input class="objekt_settings' + data.id + ' settings_name' + data.id + '" value="' + data.name + '"></b>',
      newTableRow + '<p><input type="color" class="settings_bg_color' + data.id + '" value="' + data.header_bg + '"></p>',
      newTableRow + '<p><input type="color" class="settings_txt_color' + data.id + '" value="' + data.header_color + '"></p>',
      newTableRow + '<p><input type="color" class="settings_leer_bg' + data.id + '" value="' + data.leer_bg + '"></p>',
      newTableRow + '<input class="input-size settings_min_height' + data.id + '" value="' + data.min_height + '">',
      newTableRow + '<input class="input-size settings_week_size' + data.id + '"  value="' + data.size_header + '">',
      newTableRow + '<input class="input-size settings_content_size' + data.id + '" value="' + data.size_content + '">',
      newTableRow + '<input class="input-size settings_time_size' + data.id + '" value="' + data.size_time + '">',
      newTableRow + '<span data-id="' + data.id + '" type="button" class="btn-show-formular btn-edit-small"> <i class="fa fa-edit"></i></span>',
      newTableRow + '<span data-id="' + data.id + '" type="button" class="btn-show-drop-formular btn-edit-small"> <i class="fa fa-cogs"></i></span>',
      newTableRow + '<button data-id="' + data.id + '" class="btn-ajax-save-settings btn btn-primary-outline" disabled><i class="fa fa-save"></i>&nbsp; ' + data.sprache[0] + '</button>',
      newTableRow + '<button data-id="' + data.id + '" type="button" class="btn-delete-settings btn btn-danger-outline"><i class="fa fa-trash"></i>&nbsp; ' + data.sprache[1] + '</button>'
    ]).draw(false);
    $("#add_standard_settings").trigger("reset");
    $("#add_settings").hide();
    $("#tableSettings").show(400);
  }

  /*++++++++++++++++++++++++++++++++++++
  ++++++++ TABLE EDIT SETTINGS  ++++++++
  ++++++++++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.btn-ajax-save-settings', function() {
    var id = $(this).attr('data-id');
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'update_settings',
      id: id,
      'name': $(".settings_name" + id + "").val(),
      'header_bg': $(".settings_bg_color" + id + "").val(),
      'header_color': $(".settings_txt_color" + id + "").val(),
      'leer_bg': $(".settings_leer_bg" + id + "").val(),
      'min_height': $(".settings_min_height" + id + "").val(),
      'size_header': $(".settings_week_size" + id + "").val(),
      'content_size': $(".settings_content_size" + id + "").val(),
      'datum_size': $(".settings_time_size" + id + "").val()
    }, function(data) {
      if (data.status) {
        success_message(data.msg);
      } else {
        warning_message(data.msg);
      }
    });
  });

  /*+++++++++++++++++++++++++++++++
  ++++++++ TABLE ADD DAYS  ++++++++
  +++++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.btn-save-weekdays', function() {
    var id = $(this).attr('data-id');
    var method = $(this).attr('data-method');
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: method,
      id: id,
      'sprache': $(".object_weekdays" + id + "").val(),
      'montag': $(".object_montag" + id + "").val(),
      'dienstag': $(".object_dienstag" + id + "").val(),
      'mittwoch': $(".object_mittwoch" + id + "").val(),
      'donnerstag': $(".object_donnerstag" + id + "").val(),
      'freitag': $(".object_freitag" + id + "").val(),
      'samstag': $(".object_samstag" + id + "").val(),
      'sonntag': $(".object_sonntag" + id + "").val()
    }, function(data) {
      if (data.status) {
        success_message(data.msg);
      } else {
        warning_message(data.msg);
      }
    });
  });

  /*+++++++++++++++++++++++++++++++++++++++++
  ++++++++ TABLE SAVE AJAX Category  ++++++++
  +++++++++++++++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.btn-save-category', function() {
    var id = $(this).attr('data-id');
    var method = $(this).attr('data-method');
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: method,
      id: id,
      'name': $(".category_name" + id + "").val(),
      'bg_color': $(".objekt_bg_color" + id + "").val(),
      'txt_color': $(".objekt_txt_color" + id + "").val(),
      'hover_bg': $(".objekt_hover_color" + id + "").val(),
      'hover_txt': $(".objekt_hover_txt" + id + "").val()
    }, function(data) {
      if (data.status) {
        success_message(data.msg);
      } else {
        warning_message(data.msg);
      }
    });
  });

  function add_weekdays(data, sprache) {
    var t = $('#WeekdaysTable').DataTable();
    var newTableRow = '';

    $(".select-lang").append('<option value="' + data.id + '">' + data.sprache + '</option>');

    t.row.add([
      newTableRow + '<p><input class="settings_name object_weekdays' + data.id + '" value="' + data.sprache + '"></p>',
      newTableRow + '<p><input class="settings_name object_montag' + data.id + '" value="' + data.montag + '"></p>',
      newTableRow + '<p><input class="settings_name object_dienstag' + data.id + '" value="' + data.dienstag + '"></p>',
      newTableRow + '<p><input class="settings_name object_mittwoch' + data.id + '" value="' + data.mittwoch + '"></p>',
      newTableRow + '<p><input class="settings_name object_donnerstag' + data.id + '" value="' + data.donnerstag + '"></p>',
      newTableRow + '<p><input class="settings_name object_freitag' + data.id + '" value="' + data.freitag + '"></p>',
      newTableRow + '<p><input class="settings_name object_samstag' + data.id + '" value="' + data.samstag + '"></p>',
      newTableRow + '<p><input class="settings_name object_sonntag' + data.id + '" value="' + data.sonntag + '"></p>',
      newTableRow + '<button data-id="' + data.id + '" type="button" class="btn-delete-weekdays btn btn-danger-outline"><i class="fa fa-trash"></i>&nbsp; ' + sprache[1] + '</button>',
      newTableRow + '<button data-method="edit_weekdays" data-id="' + data.id + '"  type="button" class="btn-save-weekdays btn btn-primary-outline"><i class="fa fa-save"></i>&nbsp; ' + sprache[0] + '</button></form>'
    ]).draw(false);

    $("#add_weekdays").hide();
    $("#table-weekdays").show(400);
  }

  /*+++++++++++++++++++++++++++++++++++
  ++++++++ TABLE ADD Category  ++++++++
  +++++++++++++++++++++++++++++++++++++
  */
  function add_category(data, sprache) {

    $("#select_category").append('<option value="' + data.id + '">' + data.name + '</option>');
    var t = $('#CategoryTable').DataTable();
    var newTableRow = '';
    var html = '<label class="check-container"> aktiv:';
    html += '<input id="catgory_ckeck' + data.id + '" data-id="' + data.id + '" class="category-aktiv" name="aktiv" type="checkbox" checked>';
    html += '<span class="checkmark"></span></label>';

    var html2 = '<label class="check-container">';
    html2 += '<input data-id="' + data.id + '" class="select-category" type="checkbox">';
    html2 += '<span class="select.checkmark"></span>';
    html2 += '</label>';

    t.row.add([
      newTableRow + html,
      newTableRow + '<p class="objekt_category' + data.id + '"><input class="category_name' + data.id + '" value="' + data.name + '"> </p>',
      newTableRow + '<p><input type="text"  class="color objekt_bg_color' + data.id + '" value="' + data.bg_color + '" style="background-color:' + data.bg_color + '"></p>',
      newTableRow + '<p><input type="text"  class="color objekt_txt_color' + data.id + '" value="' + data.txt_color + '"style="background-color:' + data.txt_color + '"></p>',
      newTableRow + '<p><input type="text"  class="color objekt_hover_color' + data.id + '" value="' + data.hover_bg + '"style="background-color:' + data.hover_bg + '"></p>',
      newTableRow + '<p><input type="text"  class="color objekt_hover_txt' + data.id + '" value="' + data.hover_txt + '"style="background-color:' + data.hover_txt + '"></p>',
      newTableRow + '<button data-id="' + data.id + '" type="button" class="btn-delete-category btn btn-danger-outline"><i class="fa fa-trash"></i>&nbsp; ' + sprache[1] + '</button>',
      newTableRow + '<button data-method="edit_category" data-id="' + data.id + '"  type="button" class="btn btn-primary-outline" disabled><i class="fa fa-save"></i>&nbsp; ' + sprache[0] + '</button></form>',
      newTableRow + html2
    ]).draw(false);

    $("#add_category").hide();
    $("#table-kategorie").show(400);
  }

  /*+++++++++++++++++++++++++++++++
  ++++++++ DELETE EVENT +++++++++++
  +++++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.event-delete', function() {
    var id = $(this).attr('data-id');
    if (id) {
      $.post(apd_ajax_obj.ajax_url, {
        '_ajax_nonce': apd_ajax_obj.nonce,
        'action': 'add_apgHandle',
        method: 'load_language',
        id: id,
        msg_id: 2
      }, function(data) {
        if (data.status) {
          var warn_head = data.sprache[0];
          var warn_content = data.sprache[1];
          var warn_btn = data.sprache[2];
          var btn_abort = data.sprache[3];
          var delete_funtion = delete_event;
          warn_delete(delete_funtion, data.id, warn_head, warn_content, warn_btn, btn_abort);
        }
      });
    }
  });

  function delete_event(id) {
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'delete_event',
      id: id
    }, function(data) {
      if (data.status) {
        $("#event-id" + data.id + "").remove();
        success_message(data.msg);
      } else {
        warning_message(data.msg);
      }
    });
  }

  /*+++++++++++++++++++++++++++++++
  ++++++++ DELETE SETTINGS ++++++++
  +++++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.btn-delete-settings', function() {
    var id = $(this).attr('data-id');
    if (id) {
      $.post(apd_ajax_obj.ajax_url, {
        '_ajax_nonce': apd_ajax_obj.nonce,
        'action': 'add_apgHandle',
        method: 'load_language',
        id: id,
        msg_id: 3
      }, function(data) {
        if (data.status) {
          var warn_head = data.sprache[0];
          var warn_content = data.sprache[1];
          var warn_btn = data.sprache[2];
          var btn_abort = data.sprache[3];
          var delete_funtion = delete_settings;
          warn_delete(delete_funtion, data.id, warn_head, warn_content, warn_btn, btn_abort);
        }
      });
    }
  });

  function delete_settings(id) {
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'delete_settings',
      id: id
    }, function(data) {
      if (data.status) {
        $(".select-settings option[value='" + data.id + "']").remove();
        var table = $('#StartTable').DataTable();
        table
          .row($(".objekt_settings" + data.id + "").parents('tr'))
          .remove()
          .draw();

        success_message(data.msg);
      } else {
        warning_message(data.msg);
      }
    });
  }

  /*+++++++++++++++++++++++++++++++
  ++++++++ DELETE SETTINGS ++++++++
  +++++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.btn-delete-weekdays', function() {
    var id = $(this).attr('data-id');
    if (id) {
      $.post(apd_ajax_obj.ajax_url, {
        '_ajax_nonce': apd_ajax_obj.nonce,
        'action': 'add_apgHandle',
        method: 'load_language',
        id: id,
        msg_id: 4
      }, function(data) {
        if (data.status) {
          var warn_head = data.sprache[0];
          var warn_content = data.sprache[1];
          var warn_btn = data.sprache[2];
          var btn_abort = data.sprache[3];
          var delete_funtion = delete_weekdays;
          warn_delete(delete_funtion, data.id, warn_head, warn_content, warn_btn, btn_abort);
        }
      });
    }
  });

  function delete_weekdays(id) {
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'delete_weekdays',
      id: id
    }, function(data) {
      if (data.status) {
        $(".select-lang option[value='" + data.id + "']").remove();
        var table = $('#WeekdaysTable').DataTable();
        table
          .row($(".object_weekdays" + data.id + "").parents('tr'))
          .remove()
          .draw();
        success_message(data.msg);
      } else {
        warning_message(data.msg);
      }
    });
  }

  /*++++++++++++++++++++++++++++++++++++++
  ++++++++ DELETE Kategorie Seite ++++++++
  ++++++++++++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.btn-delete-seite', function() {
    var id = $(this).attr('data-id');
    if (id) {
      $.post(apd_ajax_obj.ajax_url, {
        '_ajax_nonce': apd_ajax_obj.nonce,
        'action': 'add_apgHandle',
        method: 'load_language',
        id: id,
        msg_id: 5
      }, function(data) {
        if (data.status) {
          var warn_head = data.sprache[0];
          var warn_content = data.sprache[1];
          var warn_btn = data.sprache[2];
          var btn_abort = data.sprache[3];
          var delete_funtion = delete_seite;
          warn_delete(delete_funtion, data.id, warn_head, warn_content, warn_btn, btn_abort);
        }
      });
    }
  });

  function delete_seite(id) {
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'delete_seite',
      id: id
    }, function(data) {
      if (data.status) {
        $("#select_category").append('<option value="' + data.id + '">' + data.name + '</option>');
        var table = $('#SeitenTable').DataTable();
        table
          .row($(".seiten_objekt" + data.id + "").parents('tr'))
          .remove()
          .draw();
        success_message(data.msg);
      } else {
        warning_message(data.msg);
      }
    });
  }

  /*++++++++++++++++++++++++++++
  ++++++++ DELETE GROUP ++++++++
  ++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.btn-delete-group', function() {
    var id = $(this).attr('data-id');
    if (id) {
      $.post(apd_ajax_obj.ajax_url, {
        '_ajax_nonce': apd_ajax_obj.nonce,
        'action': 'add_apgHandle',
        method: 'load_language',
        id: id,
        msg_id: 6
      }, function(data) {
        if (data.status) {
          var warn_head = data.sprache[0];
          var warn_content = data.sprache[1];
          var warn_btn = data.sprache[2];
          var btn_abort = data.sprache[3];
          var delete_funtion = delete_group;
          warn_delete(delete_funtion, data.id, warn_head, warn_content, warn_btn, btn_abort);
        }
      });
    }
  });

  function delete_group(id) {
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'delete_group',
      id: id
    }, function(data) {
      if (data.status) {
        var table = $('#GroupTable').DataTable();
        table
          .row($(".objekt_group" + data.id + "").parents('tr'))
          .remove()
          .draw();
        success_message(data.msg);
      } else {
        warning_message(data.msg);
      }
    });
  }

  /*+++++++++++++++++++++++++++++++
  ++++++++ DELETE KATEGORY ++++++++
  +++++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.btn-delete-category', function() {
    var id = $(this).attr('data-id');
    if (id) {
      $.post(apd_ajax_obj.ajax_url, {
        '_ajax_nonce': apd_ajax_obj.nonce,
        'action': 'add_apgHandle',
        method: 'load_language',
        id: id,
        msg_id: 1
      }, function(data) {
        if (data.status) {
          var warn_head = data.sprache[0];
          var warn_content = data.sprache[1];
          var warn_btn = data.sprache[2];
          var btn_abort = data.sprache[3];
          var delete_funtion = delete_category;
          warn_delete(delete_funtion, data.id, warn_head, warn_content, warn_btn, btn_abort);
        }
      });
    }
  });

  function delete_category(id) {
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'delete_category',
      id: id
    }, function(data) {
      $('.select-category').removeAttr('checked');
      if (data.status) {
        $("#select_category option[value='" + data.id + "']").remove();
        var table = $('#CategoryTable').DataTable();
        table
          .row($(".objekt_category" + data.id + "").parents('tr'))
          .remove()
          .draw();
        success_message(data.msg);
      } else {
        warning_message(data.msg);
      }
    });
  }

  /*++++++++++++++++++++++++++
  ++++++++ EVENT EDIT ++++++++
  ++++++++++++++++++++++++++++
  */
  $(document).on('click', '.event-edit', function() {
    var id = $(this).attr('data-id');
    var group_id = $(this).attr('data-group');

    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'event_edit',
      id: id,
      group_id: group_id
    }, function(data) {
      if (data.status) {
        var record = data.record;
        var html = '';
        html += '<br><hr><h1 class="text-center"><i class="text-blue fa fa-edit"></i>&nbsp;' + data.lang_files[0] + '</h1>';
        html += '<hr />';
        html += '<br />';
        html += '<form class="send-apd-settings" action="#" method="post">';
        html += '<input type="hidden" name="method" value="edit_eintrag" />';
        html += '<input type="hidden" name="id" value="' + data.id + '" />';
        html += '<input type="hidden" name="group_id" value="' + data.group_id + '" />';
        html += '<div class="settings-flex">';
        html += '<div class="settings-item-100">';
        html += '<br />';
        html += '<a href="#" role="button" class="btn-return button-secondary" ><i class="fa fa-reply-all"></i>&nbsp;' + data.lang_files[1] + '</a>';
        html += '<br /><hr /><br />';
        html += '</div>';
        html += '</div>';

        html += '<div class="settings-flex">';
        html += '<div class="settings-item">';
        html += '<label class="form-label">' + data.lang_files[2] + ':</label>';
        html += '<select class="custom-select eintrag_name" name="wochentag">';
        html += '<option value="0">' + data.lang_files[10] + '...</option>';
        var day_sel = '';
        $.each(data.days, function(key, val) {
          if (record.day_id == val.id) {
            day_sel = ' selected';
          } else {
            day_sel = '';
          }
          html += '<option value="' + val.id + '" ' + day_sel + '>' + val.day + '</option>';
        });
        html += '</select>';
        html += '</div>';
        html += '<div class="settings-item">';
        html += '</div>';
        html += '</div>';
        html += '<div class="settings-flex">';
        html += '<div class="settings-item">';
        html += '<label class="form-label">' + data.lang_files[3] + ':</label>';
        html += '<input type="text" class="eintrag_name" value="' + record.time_von + '" placeholder="09:00" name="time_von">';
        html += '</div>';
        html += '<div class="settings-item">';
        html += '<label class="form-label">' + data.lang_files[4] + ':</label>';
        html += '<input type="text" class="eintrag_name" value="' + record.time_bis + '" placeholder="10:00" name="time_bis">';
        html += '</div>';
        html += '</div>';
        html += '<div class="settings-flex">';
        html += '<div class="settings-item">';
        html += '<label class="form-label">' + data.lang_files[6] + ':</label>';
        html += '<input type="text" class="eintrag_name" value="' + record.content + '" placeholder="Core Work" name="content">';
        html += '</div>';
        html += '<div class="settings-item">';

        var leer_checked = '';
        var cat_disabled = '';
        if (record.leer == '1') {
          leer_checked = 'checked';
          cat_disabled = ' disabled';
        }
        if (record.leer == '0') {
          leer_checked = '';
          cat_disabled = '';
        }

        html += '<label class="form-label">' + data.lang_files[5] + ':</label>';
        html += '<select id="cat-select" class="cat-sel custom-select eintrag_name" name="category" ' + cat_disabled + '>';
        html += '<option value="0">' + data.lang_files[11] + '...</option>';

        var cat_sel = '';
        $.each(data.categorys, function(key, val) {
          if (record.cat_id == val.id) {
            cat_sel = ' selected';
          } else {
            cat_sel = '';
          }
          html += '<option value="' + val.id + '" ' + cat_sel + '>' + val.name + '</option>';
        });
        html += '</select>';
        html += '</div>';
        html += '</div>';

        html += '<div class="settings-flex">';
        html += '<div class="settings-item"></div>';
        html += '<div class="settings-item">';
        html += '<label class="check-container">';
        html += '' + data.lang_files[9] + ':';
        html += '<input data-id="' + data.id + '" class="leer_checked" name="leer" type="checkbox" ' + leer_checked + '>';
        html += '<span class="checkmark"></span>';
        html += '</label>';
        html += '</div>';
        html += '</div>';

        html += '<hr /><br />';
        html += '<div class="settings-flex">';
        html += '<div class="settings-item">';
        html += '<div class="btn-group">';
        html += '<button type="submit" class="button-primary"><i class="fa fa-plus"></i>&nbsp;' + data.lang_files[7] + '</button>';
        html += '<a href="#" role="button" class="btn-close button-secondary" style="margin-right:1rem;"><i class="text-red fa fa-close"></i>&nbsp;' + data.lang_files[8] + '</a>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</form>';
        html += '<br />';
        html += '<hr>';

        $("#show_events").hide();
        $("#edit-event").html(html);
        $("#edit-event").show(400);
      } else {
        warning_message('Ein Fehler ist aufgetreten!');
      }
    });
  });

  /*++++++++++++++++++++++++++++++++++
  ++++++++ CHANGE EVENT AKTIV ++++++++
  ++++++++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.event-aktiv', function() {
    var id = $(this).attr('data-id');
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'change_event_aktiv',
      id: id
    }, function(data) {
      if (data.status) {
        success_message(data.msg);
      } else {
        warning_message(data.msg);
      }
    });
  });

  /*+++++++++++++++++++++++++++++++++++++
  ++++++++ CHANGE Catetgory AKTIV ++++++++
  +++++++++++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.category-aktiv', function() {
    var id = $(this).attr('data-id');
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'change_category_aktiv',
      id: id
    }, function(data) {
      if (data.status) {
        success_message(data.msg);
      } else {
        warning_message(data.msg);
      }
    });
  });

  /*+++++++++++++++++++++++++++++++++++++
  ++++++++ CHANGE WEEKKDAY AKTIV ++++++++
  +++++++++++++++++++++++++++++++++++++++
  */

  $(document).on('click', '.weekdays-aktiv', function() {
    var id = $(this).attr('data-id');
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'change_weekdays_aktiv',
      id: id
    }, function(data) {
      if (data.status) {

        $("#weekdays_ckeck" + data.new_id + "").attr('checked');
        $("#weekdays_ckeck" + data.old_id + "").removeAttr('checked');
        success_message(data.msg);
      } else {
        warning_message(data.msg);
      }
    });
  });

  /*+++++++++++++++++++++++++++++++++++
  ++++++++ Show Modal Settings ++++++++
  +++++++++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.btn-show-formular', function() {
    var id = $(this).attr('data-id');
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'get_modal_settings',
      id: id
    }, function(data) {
      if (data.status) {
        if(data.resize_aktiv){
          $('.auto-aktiv').prop('checked',true);
        } else {
            $('.auto-aktiv').prop('checked',false);
        }
        $('.send-apd-settings .select-width-container').html(data.cont_widht);
        $('.send-apd-settings input[name="margin_bottom"]').val(data.margin_bottom);
        $('.send-apd-settings input[name="margin_left"]').val(data.margin_left);
        $('.send-apd-settings input[name="margin_right"]').val(data.margin_right);
        $('.send-apd-settings input[name="margin_top"]').val(data.margin_top);
        $('.send-apd-settings input[name="padding_bottom"]').val(data.padding_bottom);
        $('.send-apd-settings input[name="padding_left"]').val(data.padding_left);
        $('.send-apd-settings input[name="padding_right"]').val(data.padding_right);
        $('.send-apd-settings input[name="padding_top"]').val(data.padding_top);
        $('.send-apd-settings .settingsID').val(data.id);
        $('.send-apd-settings .modalMethod').val('update_cont_settings');
        $(".title-form-modal").text(data.name);
        $("#meinModal.modal-overlay").show();
      } else {
        warning_message(data.msg);
      }
    });
  });

  /*+++++++++++++++++++++++++++++++++++
  ++++++++ Show DropDown Modal Settings ++++++++
  +++++++++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.btn-show-drop-formular', function() {
    var id = $(this).attr('data-id');
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'get_drop_modal_settings',
      id: id
    }, function(data) {
      if (data.status) {
        $('#DropModal .send-apd-settings input[name="bezeichnung"]').val(data.drop_bezeichnung);
        $('#DropModal .send-apd-settings input[name="bg_color"]').val(data.drop_bg);
        //$('#DropModal .send-apd-settings input[name="bg_color"]').css('background-color', data.drop_bg );
        $('#DropModal .send-apd-settings input[name="txt_color"]').val(data.drop_txt);
        //$('#DropModal .send-apd-settings input[name="txt_color"]').css('background-color', data.drop_txt );
        $('#DropModal .send-apd-settings input[name="bg_hover_color"]').val(data.drop_hover_bg);
        //$('#DropModal .send-apd-settings input[name="bg_hover_color"]').css('background-color', data.drop_hover_bg );
        $('#DropModal .send-apd-settings input[name="font_size"]').val(data.drop_txt_size);
        if(data.drop_aktiv){
          $('.drop-aktiv').prop('checked',true);
        } else {
            $('.drop-aktiv').prop('checked',false);
        }
        $('.send-apd-settings .settingsID').val(data.id);
        $('.send-apd-settings .modalMethod').val('edit_dropdown');
        $("#DropModal.modal-overlay").show();
      } else {
        warning_message(data.msg);
      }
    });
  });

  /*+++++++++++++++++++++++++++++++++++++
  ++++++++ CHANGE SETTINGS AKTIV ++++++++
  +++++++++++++++++++++++++++++++++++++++
  */
  $(document).on('click', '.settings-aktiv', function() {
    var id = $(this).attr('data-id');
    $.post(apd_ajax_obj.ajax_url, {
      '_ajax_nonce': apd_ajax_obj.nonce,
      'action': 'add_apgHandle',
      method: 'change_aktiv_settings',
      id: id
    }, function(data) {
      if (data.status) {

        $("#settings_ckeck" + data.new_id + "").attr('checked');
        $("#settings_ckeck" + data.old_id + "").removeAttr('checked');
        success_message(data.msg);
      } else {
        warning_message(data.msg);
      }
    });
  });

  /*+++++++++++++++++++++++++++++++
  ++++++++ SWAL MESSAGE +++++++++++
  +++++++++++++++++++++++++++++++++
  */
  function warn_delete(delete_funtion, id, warn_head, warn_content, warn_btn, btn_abort) {
    swal({
      icon: "info",
      title: warn_head,
      text: warn_content,
      buttons: {
        cancel: btn_abort,
        senden: {
          text: warn_btn,
          value: 'delete'
        }
      }
    }).then((value) => {
      switch (value) {
        case "delete":
          //funktion aufrufen
          delete_funtion(id);
          break;
      }
    });
  }

  /*+++++++++++++++++++++++++
   * +++++++ Serialize ++++++
   * ++++++++++++++++++++++++
   */
  $.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
      if (o[this.name] !== undefined) {
        if (!o[this.name].push) {
          o[this.name] = [o[this.name]];
        }
        o[this.name].push(this.value || '');
      } else {
        o[this.name] = this.value || '';
      }
    });
    return o;
  };

  function success_message(msg) {
    var x = document.getElementById("snackbar-success");
    $("#snackbar-success").text(msg);
    x.className = "show";
    setTimeout(function() {
      x.className = x.className.replace("show", "");
    }, 3000);
  }

  function warning_message(msg) {
    var x = document.getElementById("snackbar-warning");
    $("#snackbar-warning").text(msg);
    x.className = "show";
    setTimeout(function() {
      x.className = x.className.replace("show", "");
    }, 3000);
  }

  /*=================MODAL =============================*/

  $(document).on('click', '#close-button', function() {
    $("#meinModal.modal-overlay").hide();
  });

  window.addEventListener("mouseup", function(event) {
    if (!$(event.target).closest("#meinModal .modal,.open-button").length) {
      $("#meinModal.modal-overlay").hide();
    }
  });

  //DropDown Settings Modal
  $(document).on('click', '#close-button', function() {
    $("#DropModal.modal-overlay").hide();
  });

  window.addEventListener("mouseup", function(event) {
    if (!$(event.target).closest("#DropModal .modal,.open-button").length) {
      $("#DropModal.modal-overlay").hide();
    }
  });

  /*+++++++++++++++++++++++++++++
   * +++++++ TABS SETTINGS ++++++
   * ++++++++++++++++++++++++++++
   */
  $(function() {
    $('.tab-panels .tabs li').on('click', function() {
      var $panel = $(this).closest('.tab-panels');
      $panel.find('.tabs li.active').removeClass('active');
      $(this).addClass('active');
      //figure out which panel to show
      var panelToShow = $(this).attr('rel');
      //hide current panel
      $panel.find('.panel.active').slideUp(200, showNextPanel);
      //show next panel
      function showNextPanel() {
        $(this).removeClass('active');
        $('#' + panelToShow).slideDown(200, function() {
          $(this).addClass('active');
        });
      }
    });
  });

  /*++++++++++++++++++++++++++++++++
  ++++++++++++ SortableJs ++++++++++
  ++++++++++++++++++++++++++++++++++
  */
  var loc = window.location.search;
  var n = loc.indexOf("=") + 1;
  var seite = loc.substr(n, 19);
  switch (seite) {
    case 'art-Picture-termine':
      let elementArray1 = [];
      const element1 = document.querySelector('#dragable-list1');
      const sortable1 = Sortable.create(element1, {
        animation: 350,
        handle: ".my-handle",
        onUpdate: function(evt) {
          elementArray1 = [];
          evt.to.childNodes.forEach(element1 => {
            elementArray1.push(element1.className);
          });
          $.post(apd_ajax_obj.ajax_url, {
            '_ajax_nonce': apd_ajax_obj.nonce,
            'action': 'add_apgHandle',
            method: 'sort_events',
            formData: elementArray1,
          }, function(data) {});
        },
      });

      let elementArray2 = [];
      const element2 = document.querySelector('#dragable-list2');
      const sortable2 = Sortable.create(element2, {
        animation: 350,
        handle: ".my-handle",
        onUpdate: function(evt) {
          elementArray2 = [];
          evt.to.childNodes.forEach(element2 => {
            elementArray2.push(element2.className);
          });
          $.post(apd_ajax_obj.ajax_url, {
            '_ajax_nonce': apd_ajax_obj.nonce,
            'action': 'add_apgHandle',
            method: 'sort_events',
            formData: elementArray2,
          }, function(data) {});
        },
      });

      let elementArray3 = [];
      const element3 = document.querySelector('#dragable-list3');
      const sortable3 = Sortable.create(element3, {
        animation: 350,
        handle: ".my-handle",
        onUpdate: function(evt) {
          elementArray3 = [];
          evt.to.childNodes.forEach(element3 => {
            elementArray3.push(element3.className);
          });
          $.post(apd_ajax_obj.ajax_url, {
            '_ajax_nonce': apd_ajax_obj.nonce,
            'action': 'add_apgHandle',
            method: 'sort_events',
            formData: elementArray3,
          }, function(data) {});
        },
      });

      let elementArray4 = [];
      const element4 = document.querySelector('#dragable-list4');
      const sortable4 = Sortable.create(element4, {
        animation: 350,
        handle: ".my-handle",
        onUpdate: function(evt) {
          elementArray4 = [];
          evt.to.childNodes.forEach(element4 => {
            elementArray4.push(element4.className);
          });
          $.post(apd_ajax_obj.ajax_url, {
            '_ajax_nonce': apd_ajax_obj.nonce,
            'action': 'add_apgHandle',
            method: 'sort_events',
            formData: elementArray4,
          }, function(data) {});
        },
      });

      let elementArray5 = [];
      const element5 = document.querySelector('#dragable-list5');
      const sortable5 = Sortable.create(element5, {
        animation: 350,
        handle: ".my-handle",
        onUpdate: function(evt) {
          elementArray5 = [];
          evt.to.childNodes.forEach(element5 => {
            elementArray5.push(element5.className);
          });
          $.post(apd_ajax_obj.ajax_url, {
            '_ajax_nonce': apd_ajax_obj.nonce,
            'action': 'add_apgHandle',
            method: 'sort_events',
            formData: elementArray5,
          }, function(data) {});
        },
      });

      let elementArray6 = [];
      const element6 = document.querySelector('#dragable-list6');
      const sortable6 = Sortable.create(element6, {
        animation: 350,
        handle: ".my-handle",
        onUpdate: function(evt) {
          elementArray6 = [];
          evt.to.childNodes.forEach(element6 => {
            elementArray6.push(element6.className);
          });
          $.post(apd_ajax_obj.ajax_url, {
            '_ajax_nonce': apd_ajax_obj.nonce,
            'action': 'add_apgHandle',
            method: 'sort_events',
            formData: elementArray6,
          }, function(data) {});
        },
      });

      let elementArray7 = [];
      const element7 = document.querySelector('#dragable-list7');
      const sortable7 = Sortable.create(element7, {
        animation: 350,
        handle: ".my-handle",
        onUpdate: function(evt) {
          elementArray7 = [];
          evt.to.childNodes.forEach(element7 => {
            elementArray7.push(element7.className);
          });
          $.post(apd_ajax_obj.ajax_url, {
            '_ajax_nonce': apd_ajax_obj.nonce,
            'action': 'add_apgHandle',
            method: 'sort_events',
            formData: elementArray7,
          }, function(data) {});
        },
      });
      break;
  }

}); //document
