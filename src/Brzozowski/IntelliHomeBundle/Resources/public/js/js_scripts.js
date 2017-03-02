/*!
 * Copyright 2016 Karol Brzozowski
 * Wszystkie prawa zastrzeżone
 */
 

 $(document).ready(function(){

 	function refresh()
 	{
 		window.setInterval(location.reload(true), 0);
 	}

   	$("#takeScreenshot").click(function(){
 
   		$.get("panel.php?akcja");
 
   	});

   	$("#rozbroj-wlamanie").click(function(){
 
   		location.assign("panel.php?inactive");
 
   	});


   	//$("#btnAlarmStatus :input").change(function() {
   	$('.btn-alarmStatus').on('click', function(){

   		var alarmStatus = $(this).find('input').attr('id');
   		//alert(alarmStatus);

	    if ( alarmStatus=="inactive" ) {
	   		//$.get("panel.php?inactive");
	   		location.assign("panel.php?inactive");
	   		//window.location.reload();
	    }
	    if ( alarmStatus=="starting" ) {
	   		//$.get("panel.php?starting");
	   		location.assign("panel.php?starting");
	   		//window.location.reload();
	    }
	    if ( alarmStatus=="active" ) {
	   		//$.get("panel.php?active");
	   		location.assign("panel.php?starting");
	   		//window.location.reload();
	    }
   });

   	$("#upBlindLevel").click(function(){
 
   		$.get("panel.php?upblind");
   		//window.location.href='panel.php';
         window.setTimeout(function () {location.href = "panel.php";}, 200);
 
   	});

   	$("#downBlindLevel").click(function(){
 
   		$.get("panel.php?downblind");
   		//window.location.href='panel.php';
         window.setTimeout(function () {location.href = "panel.php";}, 200);
 
   	});

   	$("#changeHeatingLevel").mousemove(function(){

		var wartosc = this.value;
		$("#showHeatingLevel b span").text(wartosc);
 
   	});

   	$("#changeHeatingLevel").change(function(){

		var wartosc = this.value;
 
   		$.get("panel.php?heating="+wartosc);
   		//window.location.href='panel.php';
         window.setTimeout(function () {location.href = "panel.php";}, 200);
 
   	});

   	$("#changeWateringStatus").click(function(){
 
   		$.get("panel.php?watering");
   		//window.location.href='panel.php';
         //window.setTimeout(window.location.href = "panel.php",1000);
         window.setTimeout(function () {location.href = "panel.php";}, 200);
 
   	});


      /* Automation */

      //$("#btnAlarmStatus :input").change(function() {
      $('.btn-HOMode').on('click', function(){

          var HOMode = $(this).find('input').attr('value');
          //var HOMode = $(this).find('input:active').val();
          //alert($(this).find("option:selected" ).text());
          //HOMode = HOMode.value;
          //alert(HOMode);

          if ( HOMode=="static" ) {
               //$.get("automation.php?static");
               location.assign("automation.php?operatingmode=0");
               //window.location.reload();
          }
          if ( HOMode=="scheduled" ) {
               //$.get("panel.php?starting");
               location.assign("automation.php?operatingmode=1");
               //window.location.reload();
          }
          if ( HOMode=="off" ) {
               //$.get("panel.php?active");
               location.assign("automation.php?operatingmode=2");
               //window.location.reload();
          }
      });

      $('.btn-ChangeTemperature').on('click', function(){

          var temp = $('#temperature').val();
          //var HOMode = $(this).find('input:active').val();
          //alert($(this).find("option:selected" ).text());
          //HOMode = HOMode.value;

          location.assign("automation.php?heatingtemperature="+temp);
      });

      $('.btn-ChangeAmplitude').on('click', function(){

          var ampl = $('#amplitude').val();
          location.assign("automation.php?heatingamplitude="+ampl);
      });

      /* Obsługa Ustawień */

      /*

      $("#saveMemorySettings").click(function(){

         var phone = $("#phone").val();
         var sirenTime = $("#siren-time").val();
         var blindSet = $("#blind-set").val();
         alert(blindSet);
 
         location.assign("settings.php?phoneNumber="+phone+"&blindSettings="+blindSet+"&sirenSettings="+sirenTime);
 
      });

      */
 
});