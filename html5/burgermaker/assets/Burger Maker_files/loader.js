////////////////////////////////////////////////////////////
// CANVAS LOADER
////////////////////////////////////////////////////////////

 /*!
 * 
 * START CANVAS PRELOADER - This is the function that runs to preload canvas asserts
 * 
 */
function initPreload(){
	toggleLoader(true);
	
	checkMobileEvent();
	
	$(window).resize(function(){
		resizeGameFunc();
	});
	resizeGameFunc();
	
	loader = new createjs.LoadQueue(false);
	manifest=[{src:'assets/background.jpg', id:'background'},
			{src:'assets/layout_game.png', id:'layoutGame'},
			{src:'assets/layout_landing.png', id:'layoutLanding'},
			{src:'assets/layout_result.png', id:'layoutResult'},
			{src:'assets/button_play.png', id:'btnPlay'},
			{src:'assets/button_playagain.png', id:'btnPlayagain'},
			{src:'assets/button_serve.png', id:'btnServe'},
			{src:'assets/icon_frame.png', id:'iconFrame'},
			{src:'assets/ingredient_bun_top.png', id:'bunTop'},
			{src:'assets/ingredient_bun_bottom.png', id:'bunBottom'},
			{src:'assets/order_mark.png', id:'orderMark'},
			{src:'assets/order_arrow.png', id:'orderIndicator'},
			{src:'assets/layout_instruction.png', id:'layoutInstruction'},
			{src:'assets/button_facebook.png', id:'btnFacebook'},
			{src:'assets/button_twitter.png', id:'btnTwitter'},
			{src:'assets/button_google.png', id:'btnGoogle'}];
			
	for(n=0;n<ingredients_arr.length;n++){
		manifest.push({src:ingredients_arr[n].image, id:ingredients_arr[n].name});
		manifest.push({src:ingredients_arr[n].thumb, id:'icon'+ingredients_arr[n].name});
	}
	
	soundOn = true;		
	if(isMobile || isTablet){
		if(!enableMobileSound){
			soundOn=false;
		}
	}
	
	if(soundOn){
		manifest.push({src:'assets/sounds/cashier.ogg', id:'soundCashier'});
		manifest.push({src:'assets/sounds/chalk.ogg', id:'soundChalk'});
		manifest.push({src:'assets/sounds/clock.ogg', id:'soundClock'});
		manifest.push({src:'assets/sounds/fooddrop1.ogg', id:'soundFoodDrop1'});
		manifest.push({src:'assets/sounds/fooddrop2.ogg', id:'soundFoodDrop2'});
		manifest.push({src:'assets/sounds/fooddrop3.ogg', id:'soundFoodDrop3'});
		manifest.push({src:'assets/sounds/gameMusic.ogg', id:'musicGame'});
		manifest.push({src:'assets/sounds/mainMusic.ogg', id:'musicMain'});
		manifest.push({src:'assets/sounds/receipt.ogg', id:'soundReceipt'});
		manifest.push({src:'assets/sounds/ring.ogg', id:'soundRing'});
		
		createjs.Sound.alternateExtensions = ["mp3"];
		loader.installPlugin(createjs.Sound);
	}
	
	loader.addEventListener("complete", handleComplete);
	loader.on("progress", handleProgress, this);
	loader.loadManifest(manifest);
}

/*!
 * 
 * CANVAS PRELOADER UPDATE - This is the function that runs to update preloder progress
 * 
 */
function handleProgress() {
	$('#mainLoader').html(Math.round(loader.progress/1*100));
}

/*!
 * 
 * CANVAS PRELOADER COMPLETE - This is the function that runs when preloader is complete
 * 
 */
function handleComplete() {
	toggleLoader(false);
	initMain();
};

/*!
 * 
 * TOGGLE LOADER - This is the function that runs to display/hide loader
 * 
 */
function toggleLoader(con){
	if(con){
		$('#mainLoader').show();
	}else{
		$('#mainLoader').hide();
	}
}