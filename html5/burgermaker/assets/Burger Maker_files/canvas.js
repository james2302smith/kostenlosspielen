////////////////////////////////////////////////////////////
// CANVAS
////////////////////////////////////////////////////////////
var stage
var canvasW=0;
var canvasH=0;

/*!
 * 
 * START GAME CANVAS - This is the function that runs to setup game canvas
 * 
 */
function initGameCanvas(w,h){
	canvasW=w;
	canvasH=h;
	stage = new createjs.Stage("gameCanvas");
	
	createjs.Touch.enable(stage);
	stage.enableMouseOver(20);
	stage.mouseMoveOutside = true;
	
	createjs.Ticker.setFPS(30);
	createjs.Ticker.addEventListener("tick", tick);	
}

var canvasContainer, mainContainer, mainBurgerContainer, gameContainer, gameBurgerContainer, gameOrderContainer, resultContainer;
var bg, layoutGame, layoutGameInstruction, layoutLanding, layoutResult, btnPlay, btnPlayAgain, btnServe, txtGameTime, txtGameScore, txtGameOrder, bunTop, bunBottom, orderMark, orderIndicator, txtResultScore, txtResultTopScore, btnFacebook, btnTwitter, btnGoogle;

$.frames={};
$.icons={};
$.ingredients={};
$.orders={};
$.marks={};

/*!
 * 
 * BUILD GAME CANVAS ASSERTS - This is the function that runs to build game canvas asserts
 * 
 */
function buildGameCanvas(){
	canvasContainer = new createjs.Container();
	mainContainer = new createjs.Container();
	gameContainer = new createjs.Container();
	resultContainer = new createjs.Container();
	
	mainBurgerContainer = new createjs.Container();
	gameBurgerContainer = new createjs.Container();
	gameOrderContainer = new createjs.Container();
	
	bg = new createjs.Bitmap(loader.getResult('background'));
	layoutLanding = new createjs.Bitmap(loader.getResult('layoutLanding'));
	layoutGame = new createjs.Bitmap(loader.getResult('layoutGame'));
	layoutGameInstruction = new createjs.Bitmap(loader.getResult('layoutInstruction'));
	layoutResult = new createjs.Bitmap(loader.getResult('layoutResult'));
	
	btnPlay = new createjs.Bitmap(loader.getResult('btnPlay'));
	btnPlayAgain = new createjs.Bitmap(loader.getResult('btnPlayagain'));
	btnServe = new createjs.Bitmap(loader.getResult('btnServe'));
	centerReg(btnPlay);
	centerReg(btnPlayAgain);
	centerReg(btnServe);
	createHitarea(btnPlay);
	createHitarea(btnPlayAgain);
	createHitarea(btnServe);
	
	btnPlay.x = canvasW/2;
	btnPlay.y = canvasH/100*90;
	btnPlayAgain.x = canvasW/2;
	btnPlayAgain.y = canvasH/100*88;
	btnServe.x = canvasW/100 * 53;
	btnServe.y = canvasH/100*92;
	
	bunTop = new createjs.Bitmap(loader.getResult('bunTop'));
	bunBottom = new createjs.Bitmap(loader.getResult('bunBottom'));
	orderMark = new createjs.Bitmap(loader.getResult('orderMark'));
	orderIndicator = new createjs.Bitmap(loader.getResult('orderIndicator'));
	centerReg(bunTop);
	centerReg(bunBottom);
	centerReg(orderMark);
	centerReg(orderIndicator);
	bunTop.regY = bunTop.image.height;
	bunBottom.regY = bunBottom.image.height;
	
	bunTop.x = 0-bunTop.image.width;
	bunTop.y = 0-bunTop.image.height;
	bunBottom.x = 0-bunBottom.image.width;
	bunBottom.y = 0-bunBottom.image.height;
	orderMark.x = 0-orderMark.image.width;
	orderMark.y = 0-orderMark.image.height;
	gameContainer.addChild(bunTop, bunBottom, orderMark, orderIndicator);
	
	var iconStartX = canvasW/100 * 9;
	var iconX = iconStartX;
	var iconY = canvasH/100 * 88;
	var iconSpaceX = 128;
	var iconSpaceY = 133;
	var curCol = 1;
	
	
	for(n=0;n<ingredients_arr.length;n++){
		$.frames[n]=new createjs.Bitmap(loader.getResult('iconFrame'));
		$.icons[n]=new createjs.Bitmap(loader.getResult('icon'+ingredients_arr[n].name));
		$.ingredients[n]=new createjs.Bitmap(loader.getResult(ingredients_arr[n].name));
		
		centerReg($.frames[n]);
		centerReg($.icons[n]);
		createHitarea($.icons[n]);
		centerReg($.ingredients[n]);
		$.ingredients[n].regY = $.ingredients[n].image.height;
		
		$.frames[n].x = iconX;
		$.frames[n].y = iconY;
		iconX += iconSpaceX;
		curCol++;
		
		if(curCol > 2){
			curCol = 1;
			iconX = iconStartX;
			iconY -= iconSpaceY;
		}
		$.icons[n].x = $.frames[n].x;
		$.icons[n].y = $.frames[n].y;
		gameContainer.addChild($.frames[n], $.icons[n], $.ingredients[n]);
		
		$.ingredients[n].x = 0-$.ingredients[n].image.width;
		$.ingredients[n].y = 0-$.ingredients[n].image.height;
	}
	
	txtGameTime = new createjs.Text();
	txtGameTime.font = "40px andadaregular";
	txtGameTime.color = "#ffffff";
	txtGameTime.text = '0 SEC';
	txtGameTime.textAlign = "center";
	txtGameTime.textBaseline='alphabetic';
	
	txtGameScore = new createjs.Text();
	txtGameScore.font = "60px andadaregular";
	txtGameScore.color = "#ffffff";
	txtGameScore.text = '0';
	txtGameScore.textAlign = "center";
	txtGameScore.textBaseline='alphabetic';
	
	txtGameOrder = new createjs.Text();
	txtGameOrder.font = "30px andadaregular";
	txtGameOrder.color = "#000000";
	txtGameOrder.text = 'ORDER 1';
	txtGameOrder.textAlign = "center";
	txtGameOrder.textBaseline='alphabetic';
	
	txtGameTime.x = txtGameScore.x = txtGameOrder.x = canvasW/100 * 88;
	txtGameScore.y = (canvasH/100*17);
	txtGameTime.y = (canvasH/100*35);
	txtGameOrder.y = (canvasH/100*51);
	
	txtResultScore = new createjs.Text();
	txtResultScore.font = "140px andadaregular";
	txtResultScore.color = "#ffffff";
	txtResultScore.text = '1000';
	txtResultScore.textAlign = "center";
	txtResultScore.textBaseline='alphabetic';
	
	txtResultTopScore = new createjs.Text();
	txtResultTopScore.font = "70px andadaregular";
	txtResultTopScore.color = "#ffffff";
	txtResultTopScore.text = '1000';
	txtResultTopScore.textAlign = "left";
	txtResultTopScore.textBaseline='alphabetic';
	
	btnFacebook = new createjs.Bitmap(loader.getResult('btnFacebook'));
	btnTwitter = new createjs.Bitmap(loader.getResult('btnTwitter'));
	btnGoogle = new createjs.Bitmap(loader.getResult('btnGoogle'));
	centerReg(btnFacebook);
	createHitarea(btnFacebook);
	centerReg(btnTwitter);
	createHitarea(btnTwitter);
	centerReg(btnGoogle);
	createHitarea(btnGoogle);
	
	btnFacebook.x = canvasW/100 * 38;
	btnTwitter.x = canvasW/100 * 52.5;
	btnGoogle.x = canvasW/100 * 65.5;
	btnFacebook.y = btnTwitter.y = btnGoogle.y = canvasH/100 * 77.5;
	
	txtResultScore.x = canvasW/2;
	txtResultScore.y = canvasH/100 * 42;
	
	txtResultTopScore.x = canvasW/100 * 55;
	txtResultTopScore.y = canvasH/100 * 62.5;
	
	mainBurgerContainer.x = canvasW/2;
	mainBurgerContainer.y = canvasH/100 * 85;
	
	gameOrderContainer.x = canvasW/100 * 88;
	gameOrderContainer.y = (canvasH/100*56);
	
	gameBurgerContainer.x = canvasW/100 * 53;
	gameBurgerContainer.y = canvasH/100 * 88;
	
	mainContainer.addChild(layoutLanding, mainBurgerContainer, btnPlay);
	gameContainer.addChild(layoutGame, layoutGameInstruction, txtGameTime, txtGameScore, txtGameOrder, gameOrderContainer, gameBurgerContainer, btnServe)
	resultContainer.addChild(layoutResult, txtResultScore, txtResultTopScore, btnFacebook, btnTwitter, btnGoogle, btnPlayAgain);
	
	canvasContainer.addChild(bg, mainContainer, gameContainer, resultContainer);
	stage.addChild(canvasContainer);
	
	resizeCanvas();
}


/*!
 * 
 * RESIZE GAME CANVAS - This is the function that runs to resize game canvas
 * 
 */
function resizeCanvas(){
 	if(canvasContainer!=undefined){
		canvasContainer.scaleX=canvasContainer.scaleY=scalePercent;
	}
}

/*!
 * 
 * REMOVE GAME CANVAS - This is the function that runs to remove game canvas
 * 
 */
 function removeGameCanvas(){
	 stage.autoClear = true;
	 stage.removeAllChildren();
	 stage.update();
	 createjs.Ticker.removeEventListener("tick", tick);
	 createjs.Ticker.removeEventListener("tick", stage);
 }

/*!
 * 
 * CANVAS LOOP - This is the function that runs for canvas loop
 * 
 */ 
function tick(event) {
	stage.update(event);
}

/*!
 * 
 * CANVAS MISC FUNCTIONS
 * 
 */
function centerReg(obj){
	obj.regX=obj.image.width/2;
	obj.regY=obj.image.height/2;
}

function createHitarea(obj){
	obj.hitArea = new createjs.Shape(new createjs.Graphics().beginFill("#000").drawRect(0, 0, obj.image.width, obj.image.height));	
}