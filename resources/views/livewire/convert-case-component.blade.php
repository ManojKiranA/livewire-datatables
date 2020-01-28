<div id="container">
    <link rel="stylesheet"  href="https://convertcase.net/css/app.css?1578916702753">

    <h1>Accidentally left the caps lock on and typed something, but can't be bothered to start again and retype it all?</h1>

    <p><label for="content">Simply enter your text and choose the case you want to convert it to.</label></p>

    <div class="row">
        <textarea 
        id="content" 
        placeholder="Type or paste your content here" 
        autofocus="" 
        wire:model.debounce.1ms="textContent"
        >
    </textarea>
    </div>

    <div class="actions">
        <button wire:click="sentenceCase" id="sentence" class="btn">Sentence case</button> 
        <button wire:click="lowerCase" id="lower" class="btn">lower case</button> 
        <button wire:click="upperCase" id="upper" class="btn">UPPER CASE</button> 
        <button wire:click="capitalizedCase"id="capitalized" class="btn">Capitalized Case</button> 
        <button id="alternating" class="btn">aLtErNaTiNg cAsE</button> 
        <button id="title" class="btn">Title Case</button> 
        <button id="inverse" class="btn">InVeRsE CaSe</button> 
        <button id="download" class="btn" data-download-target="#content" style="display: inline-block;">Download Text</button> 
        <button id="copy" class="btn" data-clipboard-target="#content">Copy to Clipboard</button> 
        <button wire:click="clear" id="clear" class="btn">Clear</button>
    </div>
    
    <div class="row counts">
    Character Count: <span id="char_count">{{$characterCount}}</span> | 
        Word Count: <span id="word_count">{{$wordCount}}</span> | 
        Line Count: <span id="line_count">{{$lineCount}}</span>
    </div>
 </div>