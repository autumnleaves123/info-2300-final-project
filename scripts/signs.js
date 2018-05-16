// referenced from http://jsfiddle.net/twTab/3/

// apparently a global variable is needed
var x;

onload = function startAnimation() {
  var words = document.getElementsByClassName("word");

  var frames = Array.apply(null, Array(words.length)).map(function () {});
  var frameCount = Array.apply(null, Array(words.length)).map(function () {});
  var counter = Array.apply(null, Array(words.length)).map(function () {});

  var toggle = false;

  for (var i = 0; i < words.length; i++) {
    frames[i] = words[i].children;
    frameCount[i] = frames[i].length - 1;
    counter[i] = 0;
  }

  // when I use a for loop to do the below operations, the code
  // does not work. I don't know why.

  words[0].onclick = function() {
    if (!toggle) {
      toggle = true;
      x = setInterval(function() {
        frames[0][counter[0] % frameCount[0]].style.display = "none";
        frames[0][++counter[0] % frameCount[0]].style.display = "block";
      }, 500);
    } else {
      clearInterval(x);
      toggle = false;
    }
  }

  words[1].onclick = function() {
    if (!toggle) {
      toggle = true;
      x = setInterval(function() {
        frames[1][counter[1] % frameCount[1]].style.display = "none";
        frames[1][++counter[1] % frameCount[1]].style.display = "block";
      }, 500);
    } else {
      clearInterval(x);
      toggle = false;
    }
  }

  words[2].onclick = function() {
    if (!toggle) {
      toggle = true;
      x = setInterval(function() {
        frames[2][counter[2] % frameCount[2]].style.display = "none";
        frames[2][++counter[2] % frameCount[2]].style.display = "block";
      }, 500);
    } else {
      clearInterval(x);
      toggle = false;
    }
  }

  words[3].onclick = function() {
    if (!toggle) {
      toggle = true;
      x = setInterval(function() {
        frames[3][counter[3] % frameCount[3]].style.display = "none";
        frames[3][++counter[3] % frameCount[3]].style.display = "block";
      }, 500);
    } else {
      clearInterval(x);
      toggle = false;
    }
  }

  words[4].onclick = function() {
    if (!toggle) {
      toggle = true;
      x = setInterval(function() {
        frames[4][counter[4] % frameCount[4]].style.display = "none";
        frames[4][++counter[4] % frameCount[4]].style.display = "block";
      }, 500);
    } else {
      clearInterval(x);
      toggle = false;
    }
  }

  words[5].onclick = function() {
    if (!toggle) {
      toggle = true;
      x = setInterval(function() {
        frames[5][counter[5] % frameCount[5]].style.display = "none";
        frames[5][++counter[5] % frameCount[5]].style.display = "block";
      }, 500);
    } else {
      clearInterval(x);
      toggle = false;
    }
  }

  words[6].onclick = function() {
    if (!toggle) {
      toggle = true;
      x = setInterval(function() {
        frames[6][counter[6] % frameCount[6]].style.display = "none";
        frames[6][++counter[6] % frameCount[6]].style.display = "block";
      }, 500);
    } else {
      clearInterval(x);
      toggle = false;
    }
  }

  words[7].onclick = function() {
    if (!toggle) {
      toggle = true;
      x = setInterval(function() {
        frames[7][counter[7] % frameCount[7]].style.display = "none";
        frames[7][++counter[7] % frameCount[7]].style.display = "block";
      }, 500);
    } else {
      clearInterval(x);
      toggle = false;
    }
  }

  words[8].onclick = function() {
    if (!toggle) {
      toggle = true;
      x = setInterval(function() {
        frames[8][counter[8] % frameCount[8]].style.display = "none";
        frames[8][++counter[8] % frameCount[8]].style.display = "block";
      }, 500);
    } else {
      clearInterval(x);
      toggle = false;
    }
  }

  words[9].onclick = function() {
    if (!toggle) {
      toggle = true;
      x = setInterval(function() {
        frames[9][counter[9] % frameCount[9]].style.display = "none";
        frames[9][++counter[9] % frameCount[9]].style.display = "block";
      }, 500);
    } else {
      clearInterval(x);
      toggle = false;
    }
  }

  words[10].onclick = function() {
    if (!toggle) {
      toggle = true;
      x = setInterval(function() {
        frames[10][counter[10] % frameCount[10]].style.display = "none";
        frames[10][++counter[10] % frameCount[10]].style.display = "block";
      }, 500);
    } else {
      clearInterval(x);
      toggle = false;
    }
  }

  words[11].onclick = function() {
    if (!toggle) {
      toggle = true;
      x = setInterval(function() {
        frames[11][counter[11] % frameCount[11]].style.display = "none";
        frames[11][++counter[11] % frameCount[11]].style.display = "block";
      }, 500);
    } else {
      clearInterval(x);
      toggle = false;
    }
  }

  words[12].onclick = function() {
    if (!toggle) {
      toggle = true;
      x = setInterval(function() {
        frames[12][counter[12] % frameCount[12]].style.display = "none";
        frames[12][++counter[12] % frameCount[12]].style.display = "block";
      }, 500);
    } else {
      clearInterval(x);
      toggle = false;
    }
  }

  words[13].onclick = function() {
    if (!toggle) {
      toggle = true;
      x = setInterval(function() {
        frames[13][counter[13] % frameCount[13]].style.display = "none";
        frames[13][++counter[13] % frameCount[13]].style.display = "block";
      }, 500);
    } else {
      clearInterval(x);
      toggle = false;
    }
  }

  words[14].onclick = function() {
    if (!toggle) {
      toggle = true;
      x = setInterval(function() {
        frames[14][counter[14] % frameCount[14]].style.display = "none";
        frames[14][++counter[14] % frameCount[14]].style.display = "block";
      }, 500);
    } else {
      clearInterval(x);
      toggle = false;
    }
  }

  words[15].onclick = function() {
    if (!toggle) {
      toggle = true;
      x = setInterval(function() {
        frames[15][counter[15] % frameCount[15]].style.display = "none";
        frames[15][++counter[15] % frameCount[15]].style.display = "block";
      }, 500);
    } else {
      clearInterval(x);
      toggle = false;
    }
  }
}
