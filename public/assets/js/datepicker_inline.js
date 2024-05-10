$(function() {
      "use strict";
      //Datepicker embedded
      var picker = $('#date_booking').daterangepicker({
        parentEl: '#daterangepicker-embedded-container',
        autoUpdateInput: false,
        autoApply :true,
        alwaysShowCalendars:true,
        minDate: moment(),
      });
      // range update listener
      picker.on('apply.daterangepicker', function(ev, picker) {
        $(this).val('checkin='+picker.startDate.format('DD-MM-Y') + '&checkout=' + picker.endDate.format('DD-MM-Y'));
      });
      // prevent hide after range selection
      picker.data('daterangepicker').hide = function () {};
      // show picker on load
      picker.data('daterangepicker').show();
  });
