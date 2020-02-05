<header>
	<div class="head">
		<img src="img/arrow.png">
		<span>Оплата проезда</span>	
	</div>
	<nav>
		<div class="tab active">Билет</div>
		<div class="tab">Проездной</div>
	</nav>
</header>
<div class="container">
	<form onsubmit="return false;">
		<div class="form-checkbox">
			<img src="img/checkbox.png">
		</div>
		<div class="form-container">
			<div class="form-header">
				<div>Проїзд(загальний)</div>
				<div>
					<span class="price">4</span>
				</div>
			</div>
			<div class="form-caption secondary-color">Количество билетов</div>
			<div class="form-control">
				<div class="form-field">
					<input class="green-color" type="number" name="count" value="1">
					<span class="secondary-color">ШТ</span>
				</div>
				<div class="form-count">
					<button id="plus" class="form-count-in"><img src="img/plus.png"></button>
					<button id="minus" class="form-count-de"><img src="img/minus.png"></button>
				</div>
			</div>
		</div>
</div>
	
	<div class="container modal">
		<div class="modal-type">
			<input id="modal-type1" type="radio" name="modal-type" value="1" checked>
			<label for="modal-type1">Трамвай</label>
		</div>
		<div class="modal-type">
			<input id="modal-type2" type="radio" name="modal-type" value="2">
			<label for="modal-type2">Троллейбус</label>
		</div>
		<div class="modal-type">
			<input id="modal-type3" type="radio" name="modal-type" value="3" disabled>
			<label for="modal-type3">Автобус (В разработке)</label>
		</div>
		<div class="modal-number">
			<input type="text" name="modal-number" placeholder="Бортовой номер" inputmode="numeric">
		</div>
		<div id="apply" class="modal-button">ОК</div>
	</div>

	<div id="payment" class="payment hidden">
		<div class="payment-amount">
			<div class="payment-caption">К оплате:</div>
			<div class="payment-summ">
				<span>4</span><span>.00</span>
			</div>
		</div>
		<div class="payment-method">
			<div class="payment-card">*0900 Карта для выплат</div>
			<div class="payment-cardvalue">185.95 грн</div>
			<div class="payment-dropdown"><img src="img/dropdown_arrow.png"></div>
		</div>
		<input type="submit" class="payment-submit" value="Купить">
	</div>
</form>

<script type="text/javascript">
	var type, number;

	document.getElementById('plus').addEventListener('click', function(){
		document.getElementsByName('count')[0].value = parseInt(document.getElementsByName('count')[0].value) + 1;
		document.getElementsByClassName('payment-summ')[0].firstElementChild.innerText = 4*parseInt(document.getElementsByName('count')[0].value);
	});

	document.getElementById('minus').addEventListener('click', function(){
		if (parseInt(document.getElementsByName('count')[0].value) > 1){
			document.getElementsByName('count')[0].value = parseInt(document.getElementsByName('count')[0].value) - 1;
			document.getElementsByClassName('payment-summ')[0].firstElementChild.innerText = 4*parseInt(document.getElementsByName('count')[0].value);
		}
	});
	document.getElementsByClassName('payment-submit')[0].addEventListener('click', function(){
		var el = document.createElement('input');
			el.name = 'type';
			el.value = type;
			el.type = 'hidden';
		document.forms[0].appendChild(el);
		var el = document.createElement('input');
			el.name = 'number';
			el.value = number;
			el.type = 'hidden';
		document.forms[0].appendChild(el);
		var time = + new Date();
		var data = {
						"timestamp": time,
						"serial": getRandomInt(10000000, 99999999),
						"type": document.forms[0].type.value,
						"count": document.forms[0].count.value,
						"activated": "0",
						"number": document.forms[0].number.value
					};

		localStorage.setItem(time , JSON.stringify(data));
		window.location.href = '/?p=2';
	});

	document.getElementById('apply').addEventListener('click', function(){
		this.parentElement.classList.toggle("hidden");

		type = document.forms[0]['modal-type'].value;
		number = document.forms[0]['modal-number'].value;

		document.getElementById('payment').classList.toggle("hidden");
	});
</script>