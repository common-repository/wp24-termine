/*jshint esversion: 6 */
jQuery(document).ready(function($) {

  var sett_arr = apd_termine_settings.container;
  var APD_TERMINE_ID = '';
  for (var i = 0; i < sett_arr.length; i++) {
    APD_TERMINE_ID = 'apd-termine-body-' + sett_arr[i].random + '';
    var termin_Container = document.getElementById(APD_TERMINE_ID);
    if (sett_arr[i].auto_resize) {
      if (termin_Container) {
        let userWidth = APD_filterZahl(sett_arr[i].container_widht);
        let screensize = $(window).width();
        let z = APD_width_container(screensize, userWidth);
        if (z < 100 && z > userWidth) {
          document.getElementById(APD_TERMINE_ID).style.width = z + '%';
        }
      }
    }
  }

  $(window).resize(function() {
    for (var i = 0; i < sett_arr.length; i++) {
      APD_TERMINE_ID = 'apd-termine-body-' + sett_arr[i].random + '';
      var termin_Container = document.getElementById(APD_TERMINE_ID);
      if (sett_arr[i].auto_resize) {
        if (termin_Container) {
          let userWidth = APD_filterZahl(sett_arr[i].container_widht);
          let screensize = $(window).width();
          let z = APD_width_container(screensize, userWidth);
          if (z < 100 && z > userWidth) {
            document.getElementById(APD_TERMINE_ID).style.width = z + '%';
          }
        }
      }
    }
  });

  function APD_width_container(screensize, termine_width) {
    let container = screensize * termine_width / 100;
    let diff = screensize - container;
    let x = 0;
    let y = 0;
    switch (termine_width) {
      case 50:
        x = 950 - diff;
        y = 950;
        break;
      case 60:
        x = 650 - diff;
        y = 650;
        break;
      case 70:
        x = 500 - diff;
        y = 500;
        break;
      case 80:
        x = 350 - diff;
        y = 350;
        break;
      case 90:
        x = 150 - diff;
        y = 150;
        break;
    }
    if (diff < y) {
      let x = y - diff;
      let width = container + x;
      let z = width * 100 / container - 100 + termine_width;
      return z;
    }

  }

  function APD_filterZahl(string) {
    zahl = parseFloat(string.match(/\d+\.?\d*/gi)[0]);
    return zahl;
  }

});
