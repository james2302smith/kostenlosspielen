////////////////////////////////////////////////////////////
// GAME
////////////////////////////////////////////////////////////

/*!
 * 
 * GAME SETTING CUSTOMIZATION START
 * 
 */
var landingBurgerBuildSpeed = 300; //animation speed for burger at landing page 
var ingredientMaxHeightMain = 320; //maximum of burger height for landing

var totalScore = 10; //total score per order
var updateScoreTextSpeed = 1000; //score text update speed

var totalTimePerIngredient = 3; //total time for 1 ingredient, eg 4 ingredients * 3 = 12 SEC
var totalTimePerIngredientDecrease = .5; //number to decrease each round for difficulty

var ingredientDropSpeed = 500; //ingredient drop speed
var ingredientDropDistance = 100; //ingredient drop distance
var ingredientMaxHeight = 530; //maximum of burger height for game
var ingredientScaleDecrease = .05; //number scale to decrease to fit maximum height
var ingredientDuplicate = true; //duplicate ingredients

var orderListStartNum = 3; //number of ingredient to start for order
var orderListSpaceY = 30; //order list text spacing
var orderListMarkY = -8; //order list mark spacing

//ingredients array list
var ingredients_arr = [{name:'meat', image:'assets/ingredient_meat.png', thumb:'assets/icon_meat.png', y:0, height:45},
 						{name:'lettuce', image:'assets/ingredient_lettuce.png', thumb:'assets/icon_lettuce.png', y:10, height:25},
						{name:'cucumber', image:'assets/ingredient_cucumber.png', thumb:'assets/icon_cucumber.png', y:0, height:10},
						{name:'tomato', image:'assets/ingredient_tomato.png', thumb:'assets/icon_tomato.png', y:0, height:10},
						{name:'egg', image:'assets/ingredient_egg.png', thumb:'assets/icon_egg.png', y:15, height:20},
						{name:'cheese', image:'assets/ingredient_cheese.png', thumb:'assets/icon_cheese.png', y:20, height:15},
						{name:'onion', image:'assets/ingredient_onion.png', thumb:'assets/icon_onion.png', y:0, height:10},
						{name:'bacon', image:'assets/ingredient_bacon.png', thumb:'assets/icon_bacon.png', y:20, height:20},
						{name:'mushroom', image:'assets/ingredient_mushroom.png', thumb:'assets/icon_mushroom.png', y:0, height:10},
						{name:'chili', image:'assets/ingredient_chili.png', thumb:'assets/icon_chili.png', y:-20, height:30}];

var bunBottomHeight = 50; //bottom burger bun height 
var bunTopHeight = 10; //top burger bun height

var playBackgroundMusic = true; //play background music
var playTimerSound = true; //play timer sound

//Social share, [SCORE] will replace with game score
var shareTitle = 'Highscore on Burger Maker is [SCORE]';//social share score title
var shareMessage = '[SCORE] is mine new highscore on Burger Maker! Try it now!'; //social share score message

/*!
 *
 * GAME SETTING CUSTOMIZATION END
 *
 */
 
var playerData = {currentScore:0, newScore:0, bestScore:0, time:0};

/*!
 * 
 * GAME BUTTONS - This is the function that runs to setup button event
 * 
 */
function buildGameButton(){
	btnPlay.cursor = "pointer";
	btnPlay.addEventListener("click", function(evt) {
		playSound('soundChalk');
		goPage('game');
	});
	
	btnServe.cursor = "pointer";
	btnServe.addEventListener("click", function(evt) {
		if(serveEnable){
			playSound('soundChalk');
			playSound('soundCashier');
			increaseScore();
			createOrder();
		}
	});
	
	btnPlayAgain.cursor = "pointer";
	btnPlayAgain.addEventListener("click", function(evt) {
		playSound('soundChalk');
		goPage('game');
	});
	
	for(n=0;n<ingredients_arr.length;n++){
		$.icons[n].clicknum = n;
		$.icons[n].cursor = "pointer";
		$.icons[n].addEventListener("click", function(evt) {
			checkSelectIngredient(evt.target.clicknum);
		});
	}
	
	btnFacebook.cursor = "pointer";
	btnFacebook.addEventListener("mousedown", function(evt) {
		share('facebook');
	});
	btnTwitter.cursor = "pointer";
	btnTwitter.addEventListener("mousedown", function(evt) {
		share('twitter');
	});
	btnGoogle.cursor = "pointer";
	btnGoogle.addEventListener("mousedown", function(evt) {
		share('google');
	});
}

/*!
 * 
 * DISPLAY PAGES - This is the function that runs to display pages
 * 
 */
var curPage=''
function goPage(page){
	curPage=page;
	
	mainContainer.visible=false;
	gameContainer.visible=false;
	resultContainer.visible=false;
	
	stopAnimateButton(btnPlay);
	stopAnimateButton(btnPlayAgain);
	stopSoundLoop('musicMain');
	stopSoundLoop('musicGame');
	
	var targetContainer = ''
	switch(page){
		case 'main':
			if(playBackgroundMusic){
				playSoundLoop('musicMain');
			}
			targetContainer = mainContainer;
			
			buildMainBurger();
			startAnimateButton(btnPlay);
		break;
		
		case 'game':
			if(playBackgroundMusic){
				playSoundLoop('musicGame');
			}
			targetContainer = gameContainer;
			startGame();
		break;
		
		case 'result':
			if(playBackgroundMusic){
				playSoundLoop('musicMain');
			}
			targetContainer = resultContainer;
			stopGame();
			
			if(playerData.newScore > playerData.bestScore){
				playerData.bestScore = playerData.newScore;
			}
			txtResultScore.text = Math.round(playerData.newScore);
			txtResultTopScore.text = Math.round(playerData.bestScore);
			startAnimateButton(btnPlayAgain);
		break;
	}
	
	targetContainer.alpha=0;
	targetContainer.visible=true;
	$(targetContainer)
	.clearQueue()
	.stop(true,true)
	.animate({ alpha:1 }, 500);
}

/*!
 * 
 * START GAME - This is the function that runs to start play game
 * 
 */
 function startGame(){
	 layoutGameInstruction.visible=true;
	 playerData.currentScore = 0;
	 playerData.newScore = 0;
	 playerData.time = totalTimePerIngredient;
	 
	 burgerReset(gameBurgerContainer, false);
	 resetOrder();
	 updateScore(false);
	 toggleServeButton(false);
	 
	 setTimeout(function() {
		createOrder();
	 }, 500);
}

 /*!
 * 
 * STOP GAME - This is the function that runs to stop play game
 * 
 */
function stopGame(){
	toggleGameTimer(false);
}

/*!
 * 
 * START ANIMATE BUTTON - This is the function that runs to play blinking animation
 * 
 */
function startAnimateButton(obj){
	obj.alpha=.2;
	$(obj)
	.animate({ alpha:1}, 500)
	.animate({ alpha:.2}, 500, function(){
		startAnimateButton(obj);
	});
}

/*!
 * 
 * STOP ANIMATE BUTTON - This is the function that runs to stop blinking animation
 * 
 */
function stopAnimateButton(obj){
	obj.alpha=0;
	$(obj)
	.clearQueue()
	.stop(true,true);
}


/*!
 * 
 * BURGER INGREDIENT - This is the function that runs to add and reset burger ingredient
 * 
 */
$.burgerHolder = {};
var ingredientCount = 0;
var ingredientY = 0;
var ingredientScale = 1;

function burgerReset(target, con){
	ingredientCount = 0;
	ingredientY = 0;
	ingredientScale = 1;
	target.scaleX = target.scaleY = ingredientScale;
	target.removeAllChildren();
	
	if(con)
		addBurgerBun(false, target);
}

function addBurgerIngredient(num, target){
	$.burgerHolder[ingredientCount] = $.ingredients[num].clone();
	$.burgerHolder[ingredientCount].x = 0;
	$.burgerHolder[ingredientCount].y = ingredientY+(ingredients_arr[num].y);
	
	animateIngredient($.burgerHolder[ingredientCount]);
	ingredientY -= ingredients_arr[num].height;
	
	if(randomBoolean()){
		$.burgerHolder[ingredientCount].scaleX = -1;
	}
	
	target.addChild($.burgerHolder[ingredientCount]);
	ingredientCount++;
	
	var maxHeight = target == mainBurgerContainer ? ingredientMaxHeightMain : ingredientMaxHeight;
	for(n=1;n<10;n++){
		if(target.getBounds().height * ingredientScale > maxHeight){
			ingredientScale -=ingredientScaleDecrease;
		}else{
			n=10;	
		}
	}
	target.scaleX = target.scaleY = ingredientScale;
}

/*!
 * 
 * BURGER BUN - This is the function that runs to add burger bun
 * 
 */
function addBurgerBun(con, target){
	if(!con){
		$.burgerHolder[ingredientCount] = bunBottom.clone();
		$.burgerHolder[ingredientCount].x = 0;
		$.burgerHolder[ingredientCount].y = ingredientY;
		animateIngredient($.burgerHolder[ingredientCount]);
		
		target.addChild($.burgerHolder[ingredientCount]);
		ingredientY = -(bunBottomHeight);
		ingredientCount++;
	}else{
		$.burgerHolder[ingredientCount] = bunTop.clone();
		$.burgerHolder[ingredientCount].x = 0;
		$.burgerHolder[ingredientCount].y = ingredientY + bunTopHeight;
		animateIngredient($.burgerHolder[ingredientCount]);
		
		target.addChild($.burgerHolder[ingredientCount]);
	}
}

/*!
 * 
 * INGREDIENT DROP ANIMATION - This is the function that runs to animate ingredient
 * 
 */
function animateIngredient(obj){
	var startY = obj.y;
	obj.y -= ingredientDropDistance;
	
	$(obj)
	.clearQueue()
	.stop(true,false)
	.animate({ y:startY}, {
	  duration: ingredientDropSpeed,
	  easing: "easeOutBounce"
	});	
	
	var randomFoodNum = Math.round(Math.random()*2)+1;
	playSound('soundFoodDrop'+randomFoodNum, false);
}


/*!
 * 
 * ORDER LIST - This is the function that runs to create new order list
 * 
 */
var orderMaxNum = 0;
var orderNum = 1;
var orderY = 0;
var orderRandom_arr = [];
var orderList_arr = [];
var orderListNum = 0;

function resetOrder(){
	orderNum = 1;
	orderMaxNum = orderListStartNum;
	gameOrderContainer.removeAllChildren();
	txtGameOrder.text = 'ORDER '+orderNum;
}

function createOrder(){
	playSound('soundReceipt');
	toggleServeButton(false);
	burgerReset(gameBurgerContainer, true);
	
	gameOrderContainer.removeAllChildren();
	txtGameOrder.text = 'ORDER '+orderNum;
	
	orderRandom_arr = [];
	orderList_arr = [];
	for(n=1;n<ingredients_arr.length;n++){
		orderRandom_arr.push(ingredients_arr[n].name);
	}
	
	//duplicate
	if(orderMaxNum > (ingredients_arr.length/2) && ingredientDuplicate){
		for(n=0;n<ingredients_arr.length;n++){
			orderRandom_arr.push(ingredients_arr[n].name);
		}
	}
	
	shuffle(orderRandom_arr);
	for(n=0;n<orderRandom_arr.length;n++){
		if(n<orderMaxNum){
			orderList_arr.push(orderRandom_arr[n]);
		}
	}
	
	orderList_arr.push(ingredients_arr[0].name);
	randomShuffle(orderList_arr);
	
	var countNo = orderList_arr.length;
	orderY=0;
	for(n=0;n<orderList_arr.length;n++){
		$.marks[n] = orderMark.clone();
		centerReg($.marks[n]);
		$.marks[n].x = 0;
		$.marks[n].y = orderY + orderListMarkY;
		$.marks[n].visible = false;
		
		$.orders[n]=new createjs.Text();
		$.orders[n].font = "30px frenchpressregular";
		$.orders[n].color = "#ffffff";
		$.orders[n].text = countNo+'. '+orderList_arr[n];
		$.orders[n].textAlign = "center";
		$.orders[n].textBaseline='alphabetic';
		$.orders[n].y=orderY;
		orderY+=orderListSpaceY;
		countNo--;
		
		gameOrderContainer.addChild($.orders[n], $.marks[n]);
	}
	orderListNum = orderList_arr.length-1;
	orderNum++;
	
	updateOrderIndicator();
	startAnimateOrderIndicator();
	
	toggleGameTimer(true, playerData.time*(orderMaxNum+1));
	increaseLevel();
}

function randomShuffle(arr){
	shuffle(arr);
	var checkObj = 0;
	var randomComplete = true;
	for(n=0;n<arr.length;n++){
		if(checkObj != arr[n]){
			checkObj = arr[n];
		}else{
			randomComplete=false;
			n=arr.length-1;
		}
	}
	if(!randomComplete){
		randomShuffle(arr)
	}
}

/*!
 * 
 * INGREDIENT SELECT CHECK - This is the function that runs to check ingredient select
 * 
 */
function checkSelectIngredient(num){
	layoutGameInstruction.visible=false;
	if(ingredients_arr[num].name == orderList_arr[orderListNum]){
		addBurgerIngredient(num, gameBurgerContainer);
		$.marks[orderListNum].visible = true;
		orderListNum--;
		updateOrderIndicator();
	}
	if(orderListNum==-1){
		//add bun when last ingredient, ready to show serve button
		setTimeout(function() {
			addBurgerBun(true, gameBurgerContainer);
			toggleServeButton(true);
		}, 500);
		orderListNum--;
	}
}

/*!
 * 
 * LEVEL INCREASE - This is the function that runs to increase difficulty
 * 
 */
function increaseLevel(){
	orderMaxNum++;
	if(orderMaxNum > ingredients_arr.length-1){
		playerData.time -= totalTimePerIngredientDecrease;
	}
	orderMaxNum = orderMaxNum > (ingredients_arr.length-1) ? (ingredients_arr.length-1) : orderMaxNum;
}

/*!
 * 
 * ORDER INDICATOR UPDATE - This is the function that runs to update order indicator
 * 
 */
function updateOrderIndicator(){
	if(orderListNum>=0){
		orderIndicator.visible=true;
		orderIndicator.x = Math.round(canvasW/100 * 81);
		orderIndicator.y = gameOrderContainer.y + $.marks[orderListNum].y;
	}else{
		orderIndicator.visible=false;
	}
}


/*!
 * 
 * ORDER INDICATOR ANIMATION - This is the function that runs to animate order indicator
 * 
 */
function startAnimateOrderIndicator(){
	$(orderIndicator)
	.animate({ x:Math.round(canvasW/100 * 82)}, 300)
	.animate({ x:Math.round(canvasW/100 * 81)}, 300, function(){
		startAnimateOrderIndicator();
	});	
}

/*!
 * 
 * TOGGLE SERVE BUTTON - This is the function that runs to toggle serve button
 * 
 */
var serveEnable = false;
function toggleServeButton(con){
	$(btnServe)
	.clearQueue()
	.stop(true,false);
	
	if(con){
		serveEnable = true;
		btnServe.cursor = "pointer";
		startAnimateButton(btnServe);
	}else{
		serveEnable = false;
		btnServe.cursor = "default";
		btnServe.alpha = .3;
	}
}


/*!
 * 
 * SCORE - This is the function that runs to add and update score
 * 
 */
function increaseScore(){
	playerData.newScore += totalScore;
	updateScore(true);
}

function updateScore(con){
	if(con){
		$(playerData).animate({currentScore: playerData.newScore},{
			duration: updateScoreTextSpeed,
			step: function( newScore ){
				txtGameScore.text = Math.round(playerData.currentScore);
			}
		});
	}else{
		txtGameScore.text = playerData.newScore = playerData.currentScore;
	}
}


/*!
 * 
 * MAIN PAGE BURGER ANIMATION - This is the function that runs to build burger animation
 * 
 */
var mainRandom_arr = [];
var mainList_arr = [];
var curMainNum = 0;
var maxMainNum = 7;

function buildMainBurger(){
	burgerReset(mainBurgerContainer, true);
	
	mainRandom_arr = [];
	for(n=1;n<ingredients_arr.length;n++){
		mainRandom_arr.push(ingredients_arr[n].name);
	}
	shuffle(mainRandom_arr);
	
	maxMainNum = ingredients_arr.length-2;
	for(n=0;n<mainRandom_arr.length;n++){
		if(n<maxMainNum){
			mainList_arr.push(mainRandom_arr[n]);
		}
	}
	mainList_arr.push(ingredients_arr[0].name);
	shuffle(mainList_arr);
	
	curMainNum = 0;
	loopMainBurger();
}

function loopMainBurger(){
	if(curMainNum < mainList_arr.length){
		setTimeout(function() {
			if(curPage=='main'){
				addBurgerIngredient(getIndexOfIngredients(mainList_arr[curMainNum]), mainBurgerContainer);
				curMainNum++;
				loopMainBurger();
			}
		}, landingBurgerBuildSpeed);
	}else{
		setTimeout(function() {
			if(curPage=='main'){
				addBurgerBun(true, mainBurgerContainer);
				curMainNum++;
			}
		}, landingBurgerBuildSpeed);
	}
}

/*!
 * 
 * INDEX OF INGREDIENT - This is the function that runs to get index of ingredient
 * 
 */
function getIndexOfIngredients(ingredient){
	for(n=0;n<ingredients_arr.length;n++){
		if(ingredients_arr[n].name == ingredient){
			return n;	
		}
	}
}

/*!
 * 
 * GAME TIMER - This is the function that runs for game timer
 * 
 */
var gameTimerInterval;
var gameTimerSoundInterval;
var gameTimerCount = 0;
var gameTimerMax = 0;

var timerSoundNum = 0;
var timerSoundMax = 10;

function toggleGameTimer(con, time){
	if(con){
		timerSoundNum = 0;
		gameTimerCount = gameTimerMax = time;
		txtGameTime.text=millisecondsToTime(gameTimerCount*1000);
		
		clearInterval(gameTimerInterval);
		gameTimerInterval = setInterval(function(){
			if(gameTimerCount <= 0){
				toggleGameTimer(false);
				playSound('soundRing');
				goPage('result');
			}else{
				gameTimerCount-=1;
				txtGameTime.text=millisecondsToTime(gameTimerCount*1000);
			}
		}, 1000);
		
		clearInterval(gameTimerSoundInterval);
		if(playTimerSound){
			gameTimerSoundInterval = setInterval(function(){
				if(timerSoundNum > 0){
					timerSoundNum--;
				}else{
					if(gameTimerCount > 21){
						timerSoundNum = 9;
					}else if(gameTimerCount > 11){
						timerSoundNum = 8;
					}else if(gameTimerCount > 6){
						timerSoundNum = 6;
					}else{
						timerSoundNum = 4;	
					}
					updateTimerSound();
				}
			}, 100);
		}
	}else{
		clearInterval(gameTimerInterval);
		clearInterval(gameTimerSoundInterval);
	}
}

function updateTimerSound(){
	playSound('soundClock');
}


/*!
 * 
 * MILLISECONDS CONVERT - This is the function that runs to convert milliseconds to time
 * 
 */
function millisecondsToTime(milli) {
      var milliseconds = milli % 1000;
      var seconds = Math.floor((milli / 1000) % 60);
      var minutes = Math.floor((milli / (60 * 1000)) % 60);
	  
	  if(seconds<10){
		seconds = '0'+seconds;  
	  }
	  
	  if(minutes<10){
		minutes = '0'+minutes;  
	  }
	  return seconds+' SEC';
}

/*!
 * 
 * SHARE - This is the function that runs to open share url
 * 
 */
function share(action){
	var loc = location.href
	loc = loc.substring(0, loc.lastIndexOf("/") + 1);
	var title = shareTitle.replace("[SCORE]", playerData.newScore);
	var text = shareTitle.replace("[SCORE]", playerData.newScore);
	var shareurl = '';
	
	if( action == 'twitter' ) {
		shareurl = 'https://twitter.com/intent/tweet?url='+loc+'&text='+text;
	}else if( action == 'facebook' ){
		shareurl = 'http://www.facebook.com/sharer.php?u='+encodeURIComponent(loc+'share.php?desc='+text+'&title='+title+'&url='+loc+'&thumb='+loc+'share.jpg');
	}else if( action == 'google' ){
		shareurl = 'https://plus.google.com/share?url='+loc;
	}
	
	window.open(shareurl);
}