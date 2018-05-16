onload = function startAnimation() {
  var words = document.getElementsByClassName("word");

  var frames = Array.apply(null, Array(words.length)).map(function () {});
  var frameCount = Array.apply(null, Array(words.length)).map(function () {});
  var counter = Array.apply(null, Array(words.length)).map(function () {});

  for (var i = 0; i < words.length; i++) {
    frames[i] = words[i].children;
    frameCount[i] = frames[i].length;
    counter[i] = 0;
  }

  //frames[0] = words[0].children;
  //frameCount[0] = frames[0].length;
  var k = 0;
  setInterval(function () {
    for (var i = 0; i < words.length; i++) {
      frames[i][counter[i] % frameCount[i]].style.display = "none";
      frames[i][++counter[i] % frameCount[i]].style.display = "block";
    }

    //frames[0][counter[0] % frameCount[0]].style.display = "none";
    //frames[0][++counter[0] % frameCount[0]].style.display = "block";

    //frames[1][k % frameCount[1]].style.display = "none";
    //frames[1][++k % frameCount[1]].style.display = "block";
  }, 500);
}
