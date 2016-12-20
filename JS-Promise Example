/* Original
function generateRandomNumber () {
  return new Promise(function (resolve, reject) {
    var randomNumber = Math.floor((Math.random() * 10) + 1)
    if (randomNumber <= 5) {
      resolve(randomNumber)
    } else {
      reject(randomNumber)
    }
  })
}
*/
var generateRandomNumber = function(v) {
  return new Promise(function(resolve, reject) { //alert(v);
    //return new Promise(function (resolve, reject) {
    var randomNumber = Math.floor((Math.random() * 10) + 1)
    if (randomNumber <= 5) {
      resolve(randomNumber)
    } else {
      reject(randomNumber)
    }
  })
};


generateRandomNumber(1).then(function(result) {
    document.getElementById('message').innerHTML = 'Success: ' + result
  }, function(result) {
    alert(result);
    throw new 'error';
  })
  .catch(function(error) {
    document.getElementById('message').innerHTML = 'Error: ' + error
  })
