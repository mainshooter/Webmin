var main;
var ajax;

(function() {
  main = {
    // The main object for your javascript
  }
})();

(function() {
  ajax = {
    /**
     * Sends a get request with a callback
     * @param  {[string]} url [Where we want to send the ajax request to]
     * @return {[obj]}     [The result from ajax request as a object]
     */
    get_withCallback: function(url) {
      var xhttp = new XMLHttpRequest();
      xhttp.open("GET", url, false);
      xhttp.send();

      return(xhttp);
    },
    /**
     * Sends a get request without a callback
     * @param  {[string]} url [The URL where we send the request to]
     * @return {[object]} xhhtp [The returned object]
     */
    get_withoutCallBack: function(url) {
      var xhttp = new XMLHttpRequest();
      xhttp.open("GET", url, true);
      xhttp.send();
    },
    /**
     * Sends a post ajax request with a callback
     * @param  {[string]} url            [The url where we want to send the post request to]
     * @param  {[string]} postParameters [With the post values we will fill in]
     * @return {[type]}                [description]
     */
    post_withCallback: function(url ,postParameters) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log("Done with ajax post with callBack");
        }
      };
      // contains te post values
      xhttp.open("POST", url, true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send(postParameters);

      return(xhttp);
    },
    /**
     * [description]
     * @param  {[string]} url [The url where we want to send the request to]
     * @param  {[string]} postParameters [With the postParameters in it]
     */
    post_withoutCallback: function(url, postParameters) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log("Done with ajax post without callBack");
        }
      };
      // contains te post values
      xhttp.open("POST", url, false);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send(postParameters);
    }
  }
})();
