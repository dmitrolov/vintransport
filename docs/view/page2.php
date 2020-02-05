<header>
	<div class="head">
		<img src="img/arrow.png">
		<span>Проезд</span>	
	</div>
	<nav>
		<div class="tab active">Билет</div>
		<div class="tab">Проездной</div>
	</nav>
</header>


<script id="main-script" type="text/javascript">

	var ticket_list = [];
		for (var i = 0; i < localStorage.length; i++) {
			ticket_list[i] = JSON.parse(localStorage.getItem(localStorage.key(i)));
			console.log(ticket_list);
		}
		ticket_list = ticket_list.sort(function(a, b){
			return parseInt(b.timestamp) - parseInt(a.timestamp);
		});

	for (var key in ticket_list){

		var datetime = new Date(parseInt(ticket_list[key].timestamp));

		if(datetime.getDate() < 10){ var day = "0" + datetime.getDate(); } else { var day = datetime.getDate();}
		if(datetime.getMonth() < 10){ var month = "0" + datetime.getMonth(); } else { var month = datetime.getMonth();}
		var year = datetime.getFullYear();

		if(datetime.getHours() < 10){ var hours = "0" + datetime.getHours(); } else { var hours = datetime.getHours();}
		if(datetime.getMinutes() < 10){ var minutes = "0" + datetime.getMinutes(); } else { var minutes = datetime.getMinutes();};
		if(datetime.getSeconds() < 10){ var seconds = "0" + datetime.getSeconds(); } else { var seconds = datetime.getSeconds();};
		
		if (ticket_list[key].activated == "0") {
			var button = `
					<div class="activate">
						<button type="submit" id="activate-button" data-rowid="` + ticket_list[key].timestamp + `">Закомпостировать</button>
					</div>
					<div class="timer hidden" data-start=`+ parseInt(ticket_list[key].timestamp)/1000 +`>
						<span>&nbsp;</span>
					</div>
					`;
		} else {
			var button = `
					<div class="activate hidden">
						<button type="submit" data-rowid="` + ticket_list[key].timestamp + `">Закомпостировать</button>
					</div>
					<div class="timer" data-start=`+ parseInt(ticket_list[key].timestamp)/1000 +`>
						<span>&nbsp;</span>
					</div>
					`;
		}

		if ( + new Date() < parseInt(ticket_list[key].timestamp) + 3600000) {
			var expired = 1;
			var color1 = 'primary-color';
			var color2 = 'green-color';
		} else {
			var expired = 0;
	 		var color1 = 'secondary-color';
			var color2 = 'secondary-color';
			var button = ``;
		}

		var element = document.createElement('form');
			element.id = "ticket-" + ticket_list[key].timestamp;
			element.setAttribute("onsubmit", "activate(this); return false;");
			element.innerHTML = `
								<div class="container w-100">
									<div class="company-info">
										<img src="img/company` + expired + `.png">
										<div>
											<p class="` + color1 + `">Вінниця</p>  <!-- secondary-color -->
											<p class="` + color1 + `">КП Вінницька транспортна компанія</p> <!-- secondary-color -->
											<p class="` + color1 + ` serial">` + ticket_list[key].serial + `</p> <!-- secondary-color -->
										</div>
									</div>
									<div class="logo">
										<img src="img/logo` + expired + `.png">
									</div>
									<div class="number">
										<span class="` + color1 + `">` + ticket_list[key].number + `</span> <!-- secondary-color -->
									</div>
									<div class="caption">
										<span class="secondary-color">Вагон</span>
									</div>
									<div class="data">
										<div class="date">
											<span class="secondary-color">Дата</span>
											<span class="` + color1 + `">` + day + `.` + month + `.` + year + `</span> <!-- secondary-color -->
										</div>
										<div class="time">
											<span class="secondary-color">Время</span>
											<span class="` + color1 + `">` + hours + `:` + minutes + `:` + seconds + `</span> <!-- secondary-color -->
										</div>
										<div class="type">
											<span class="secondary-color">Стандартный</span> 
											<span class="` + color1 + `">` + ticket_list[key].count + `</span> <!-- secondary-color -->
										</div>
									</div>
									<div class="descripton">
										<span class="` + color2 + `">Билет разового использования</span> <!-- green-color -->
									</div>
									` + button + `
								</div>

								`;

			document.body.insertBefore(element, document.getElementById('main-script'));

	}

	


	document.getElementsByClassName('head')[0].addEventListener('click', function(){
		window.location.href = '/?p=1';
	});

	function msToTime(duration) {
		if (duration == 1) {
			document.location.reload(true);
		}
		var seconds = Math.floor((duration) % 60),
			minutes = Math.floor((duration / 60) % 60);

		minutes = (minutes < 10) ? "0" + minutes : minutes;
		seconds = (seconds < 10) ? "0" + seconds : seconds;

		return minutes + ":" + seconds;
	}

	var timers = document.getElementsByClassName('timer');
	setInterval(function(){
		var curT = +new Date();
			curT = Math.floor(curT/1000);
		for (var i = 0; i < timers.length; i++) {
			var baseT = parseInt(timers[i].dataset.start) + 3600;
			timers[i].firstElementChild.innerText = msToTime(baseT - curT);
		}
	}, 100);

	function activate(form){
		var rowid = form.id.split("-")[1];
		var tmp_string = JSON.parse(localStorage.getItem(rowid));
			tmp_string.activated = "1";
			tmp_string = JSON.stringify(tmp_string);
			localStorage.setItem(rowid, tmp_string);
			form.getElementsByClassName('activate')[0].classList.toggle('hidden');
			form.getElementsByClassName('timer')[0].classList.toggle('hidden');
	};

</script>