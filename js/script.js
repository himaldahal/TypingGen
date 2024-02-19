document.addEventListener("DOMContentLoaded", function () {
    let typingText = document.querySelector(".typing-text p"),
        inputField = document.querySelector(".input-field"),
        mistakeTag = document.getElementById("mistakes"),
        timeTag = document.getElementById("timeLeft"),
        maxTime = 60,
        timeLeft = maxTime,
        timer,
        isTyping = false,
        cpmTag = document.getElementById("cpm"),
        wpmTag = document.getElementById("wpm"),
        tryAgainBtn = document.querySelector(".btn-try-again"),
        completedTest = false;

    let currentParagraphIndex;
    let words;
    
   
    function showResult(cpm,wpm,mistakes) {
        var modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.id = 'dynamicModal';
    
        var modalDialog = document.createElement('div');
        modalDialog.className = 'modal-dialog';
    
        var modalContent = document.createElement('div');
        modalContent.className = 'modal-content';
    
        var modalHeader = document.createElement('div');
        modalHeader.className = 'modal-header';
        modalHeader.innerHTML = `
          <h5 class="modal-title">Result</h5>
         
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        `;
    
        var modalBody = document.createElement('div');
        modalBody.className = 'modal-body';
        modalBody.innerHTML =`<div><p><strong>CPM:${cpm}</strong></p><p><strong>WPM:${wpm}</strong></p><p><strong>MISTAKES:${mistakes}</strong></p> </div>`;
    
        var modalFooter = document.createElement('div');
        modalFooter.className = 'modal-footer';
        modalFooter.innerHTML = `
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        `;
    
        modalContent.appendChild(modalHeader);
        modalContent.appendChild(modalBody);
        modalContent.appendChild(modalFooter);
    
        modalDialog.appendChild(modalContent);
        modal.appendChild(modalDialog);
    
        document.body.appendChild(modal);
    
        var dynamicModal = new bootstrap.Modal(document.getElementById('dynamicModal'));
        dynamicModal.show();
      }

    function submitRecord(wpm, cpm, mistakes) {
        const formData = new FormData();
        formData.append('wpm', wpm);
        formData.append('cpm', cpm);
        formData.append('mistakes', mistakes);
    
        fetch('/apis/records.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            console.log("Added successfully.");
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    

    function randomParagraph() {
        currentParagraphIndex = Math.floor(Math.random() * paragraphs.length);
        words = paragraphs[currentParagraphIndex].split(" ");
        typingText.innerHTML = "";
        words.forEach((word, index) => {
            let spanTag = `<span data-word-index="${index}">${word}</span> `;
            typingText.innerHTML += spanTag;
        });

        document.addEventListener("keydown", () => {
            inputField.focus();
        });
        inputField.addEventListener("click", () => {
            inputField.focus();
        });
    }

    function initTyping() {
        const spans = typingText.querySelectorAll("span");
        let typedWords = inputField.value.trim().split(/\s+/);

        spans.forEach((span, index) => {
            let typedWord = typedWords[index] || "";
            let correct = span.innerText === typedWord;

            span.classList.remove("text-success", "text-danger");

            if (typedWord.length > 0) {
                span.classList.add(correct ? "text-success" : "text-danger");
            }
        });

        if (typedWords.length >= words.length && !completedTest) {
            completedTest = true;
            inputField.disabled = true;
            tryAgainBtn.style.display = "block";
            clearInterval(timer); // Stop the timer

            // Display final statistics
            let wpm = Math.round((typedWords.length / 5) / (maxTime - timeLeft) * 60);
            wpm = wpm < 0 || !wpm || wpm === Infinity ? 0 : wpm;

            mistakeTag.innerText = countMistakes(spans, typedWords);
            wpmTag.innerText = wpm;
            cpmTag.innerText = typedWords.length;
            showResult(typedWords.length,wpm,countMistakes(spans, typedWords));
            submitRecord(wpm,typedWords.length,countMistakes(spans, typedWords));
        } else if (typedWords.length > 0 && !isTyping) {
            // Start the timer only when the user starts typing
            timer = setInterval(initTimer, 1000);
            isTyping = true;
        }
    }

    function countMistakes(spans, typedWords) {
        let mistakes = 0;
        spans.forEach((span, index) => {
            let typedWord = typedWords[index] || "";
            if (span.innerText !== typedWord) {
                mistakes++;
            }
        });
        return ((mistakes < 1 )? mistakes: (mistakes - 1)) ;
    }

    function initTimer() {
        if (isTyping && timeLeft > 0) {
            timeLeft--;
            timeTag.innerText = timeLeft;
        } else if (timeLeft === 0) {
            clearInterval(timer);
        }
    }

    function resetGame() {
        randomParagraph(); // Choose a new random paragraph
        inputField.disabled = false;
        inputField.value = "";
        clearInterval(timer);
        isTyping = false;
        completedTest = false;
        tryAgainBtn.style.display = "none";

        timeLeft = maxTime;
        timeTag.innerText = timeLeft;
        mistakeTag.innerText = 0;
        wpmTag.innerText = 0;
        cpmTag.innerText = 0;
    }

    tryAgainBtn.addEventListener("click", resetGame);
    randomParagraph();
    inputField.addEventListener("input", initTyping);

    const spansTime = document.querySelectorAll('.btn-group button');

    spansTime.forEach(span => {
        span.addEventListener('click', function () {
            // Remove the 'clicked' class from all buttons
            spansTime.forEach(btn => {
                btn.classList.remove('clicked', 'btn-primary');
                btn.classList.add('btn-secondary');
            });

            this.classList.add('clicked', 'btn-primary');
            const selectedTime = this.innerText;

            timeLeft = maxTime = selectedTime;
            resetGameTimer();
            activateTimeListItem(selectedTime);
        });
    });

    function resetGameTimer() {
        inputField.value = "";
        clearInterval(timer);
        isTyping = false;
        completedTest = false;
        tryAgainBtn.style.display = "none";

        timeTag.innerText = timeLeft;
        mistakeTag.innerText = 0;
        wpmTag.innerText = 0;
        cpmTag.innerText = 0;

        initTimer(); // Start the timer
    }

    function activateTimeListItem(selectedTime) {
        const timeListItems = document.querySelectorAll('.btn-group button');
        timeListItems.forEach(item => {
            item.classList.remove('clicked', 'btn-primary', 'btn-warning');
            item.classList.add('btn-secondary');
            if (item.innerText === selectedTime) {
                item.classList.add('clicked', 'btn-warning');
            }
        });
    }

    initTimer(); // Start the timer initially
});
