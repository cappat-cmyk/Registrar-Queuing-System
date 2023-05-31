function callCustomer(){
    var message= document.getElementById("ticketnumber").value;
    var CounterNumber= document.getElementById("CounterNumber").value;
    var prefix= "Calling Customer Number";
    var suffix='Proceed to Counter'+CounterNumber+'please';

          // Check if the browser supports the speechSynthesis API
          if ('speechSynthesis' in window) {
        // Get a reference to the speechSynthesis API
        const synth = window.speechSynthesis;
        
        // Create a new SpeechSynthesisUtterance object
        const utterance = new SpeechSynthesisUtterance(prefix+message+suffix);
        utterance.voice = synth.getVoices()[0];  // Choose a voice
        utterance.volume = 10;  // Set volume
        utterance.pitch = 1.5;
        utterance.rate = 0.75;

    
        // Speak the message
        synth.speak(utterance);
        document.getElementById("call").disabled=true;
        document.getElementById("recall").disabled=false;

        // Get the select element
        var select = document.getElementById("drpdwn_counter");

        // Get the options
        var options = select.options;

        // Set the value to select
        var valueToSelect = localStorage.getItem("selected_counter");

        // Loop through all the options to find the option with the same value as valueToSelect
        for (var i = 0; i < options.length; i++) {
        var option = options[i];
        var jsonValue = option.value;
        var values = JSON.parse(jsonValue);
        console.log(values);
        var optionCounter = values.counter;
        if (optionCounter == valueToSelect) {
            // Select the option
            option.selected = true;
            break;
            }
        }
        
        
      } else {
        // The browser does not support the speechSynthesis API
        alert('Your browser does not support the speechSynthesis API');
      }
}
