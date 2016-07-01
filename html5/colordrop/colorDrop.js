var stage;
var shapes=[];
var slots=[];
var score=0;
var pos;

function init(){
	stage = new createjs.Stage("canvas");
	pos=stage.canvas.width/2-200;
	buildShapes();
	setBlocks();
	startGame();
}
function buildShapes(){
	var colors= ['blue','red','green','yellow'];
	var i, shape, slot;
	for (var i = 0; i < colors.length; i++) {
		//create slots wwith stroke
		slot= new createjs.Shape();
		slot.graphics.beginStroke(colors[i]);
		slot.graphics.beginFill('#fff');
		slot.graphics.drawRect(0,0,100,100);
		slot.regX=slot.regY=50;
		slot.key=i;
		slot.y=80;
		slot.x=pos+130*i;
		stage.addChild(slot);
		slots.push(slot);
		//create blocks
		shape= new createjs.Shape();
		shape.graphics.beginFill(colors[i]);
		shape.graphics.drawRect(0,0,100,100);
		shape.regX=shape.regY=50;
		shape.key=i;
		shapes.push(shape);
	};
}
function setBlocks(){
	var i, r, shape;
   var l = shapes.length;
   for (i = 0; i < l; i++) {
      r = Math.floor(Math.random() * shapes.length); //return random between 1 & l
      shape = shapes[r];
      shape.homeY = 320;
      shape.homeX = (i * 130) + pos;
      shape.y = shape.homeY;
      shape.x = shape.homeX;
      shape.addEventListener("mousedown", startDrag);
      stage.addChild(shape);
      shapes.splice(r, 1);
	}
}
function startDrag(e){
	var shape=e.target;
	var slot=slots[shape.key];
	stage.addEventListener("stagemousemove",function(e1){
		shape.x=stage.mouseX;
		shape.y=stage.mouseY;
	})
	stage.addEventListener('stagemouseup', function (e) {
	      stage.removeAllEventListeners();
	      var pt = slot.globalToLocal(stage.mouseX, stage.mouseY);
	      if (slot.hitTest(pt.x, pt.y)) {
	         shape.removeEventListener("mousedown",startDrag);
	         score++;
	         createjs.Tween.get(shape).to({x:slot.x, y:slot.y}, 200,
	            createjs.Ease.quadOut).call(checkGame);
	      }
	      else {
	         createjs.Tween.get(shape).to({x:shape.homeX, y:shape.homeY}, 200,
	            createjs.Ease.quadOut);
	      }
	});
}
function checkGame(){
   if(score == 4){
      alert('You Win!');
   }
}
function startGame(){
	createjs.Ticker.setFPS(60);
	createjs.Ticker.addEventListener("tick",function(){
		stage.update();
	})
}
