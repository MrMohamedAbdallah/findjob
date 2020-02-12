let menu = document.querySelector("#menu-icon");
let nav = document.querySelector("#right-nav");
if (menu) {
    menu.addEventListener("click", () => {
        if (nav.classList.contains("open")) {
            nav.classList.remove("open");
        } else {
            nav.classList.add("open");
        }
    });

    if (window.innerWidth < 768) {
        nav.classList.remove("open");
    }
}

let navIcon = document.querySelector("#navbar-icon");
navIcon.addEventListener("click", () => {
    let navbar = document.querySelector("#lists");

    if (navbar.classList.contains("open")) {
        navbar.classList.remove("open");
    } else {
        navbar.classList.add("open");
    }
});

// Get all tabs
let tabs = document.querySelectorAll(".tab");
tabs.forEach(tab => {
    tab.addEventListener("click", () => {
        // Add inactive
        tabs.forEach(t => {
            t.classList.add("inactive");
            // Hide the target
            document.querySelector(t.dataset.show).classList.add("d-none");
        });

        // Remove inactive class
        tab.classList.remove("inactive");
        // Shwo the target
        document.querySelector(tab.dataset.show).classList.remove("d-none");
    });
});
var tagsBox = new (function() {
    // ========== Options ==========
    this.options = {
        selector: ".tag-box",
        tagClass: "tag",
        parent: "tags-container",
        close: "&times;",
        seperator: [" ", ",", "-"],
        minLength: 2,
        inputName: "tags[]",
        maxInputs: 3,
        maxReached: null
    };
    this.lastValue = ""; // Store last value

    //              ========== Init ==========
    // ========== Intial the tags functionality ==========
    this.init = (newOptions = {}) => {
        // Initialize options
        var keys = Object.keys(this.options); // Get the kes of the options

        // Set new options
        for (var i = 0; i < keys.length; i++) {
            var keyName = keys[i]; // Key name of the object
            this.options[keyName] = newOptions[keyName]
                ? newOptions[keyName]
                : this.options[keyName];
        }

        // Regex
        var pattern =
            "[a-z0-9_#]{" +
            this.options.minLength +
            ",}[" +
            this.options.seperator.join("\\") +
            "]+";
        this.regex = new RegExp(pattern, "igm");

        document.querySelectorAll("." + this.options.parent).forEach(el => {
            el.addEventListener("click", e => {
                if (e.target.classList.contains("fa-times")) {
                    e.target.parentNode.parentNode.parentNode.removeChild(e.target.parentNode.parentNode);
                }
            });
        });

        start();
    };

    // Start the functionality
    var start = () => {
        // Select all elements
        document.querySelectorAll(this.options.selector).forEach(box => {
            // Click to focus on parent
            box.parentNode.addEventListener("click", e => {
                if (e.target.classList.contains(this.options.parent)) {
                    box.focus();
                }
            });

            // Prevent submit
            // Key up event
            box.addEventListener("keypress", e => {
                //Prevent default behaviour
                if (e.keyCode == 13 || e.which == 13) {
                    e.preventDefault();
                    return false;
                }
            });

            // Key up event
            box.addEventListener("keyup", e => {
                //Prevent default behaviour
                e.preventDefault();

                // The value of the input
                var value = box.value;

                if (e.keyCode == 13) {
                    value = value + " ";
                }

                // Backspace
                if (value == "" && this.lastValue == "" && e.keyCode == 8) {
                    // Get last tag if exists
                    var tags = document.querySelectorAll(
                        "." + this.options.tagClass
                    );

                    if (tags.length == 0) return; // Return point

                    // Get last tag
                    var lastTag = tags[tags.length - 1];
                    var lastTagText = lastTag.firstElementChild.innerText; // Last tag text

                    // Delete the tag
                    lastTag.parentNode.removeChild(lastTag);

                    // Set the last tag value to the input value
                    box.value = lastTagText;
                    box.select();
                }

                let numberOfInputs = document.querySelectorAll(
                    "." + this.options.tagClass
                ).length;

                if (value.length > this.options.minLength) {
                    // Maximum number of inputs
                    if (numberOfInputs >= this.options.maxInputs) {
                        if (typeof this.options.maxReached == "function") {
                            // Call the callback method
                            this.options.maxReached();
                        }
                        return;
                    }

                    // Regex
                    var matches = value.match(this.regex);

                    // Add elements
                    if (matches) {
                        for (
                            var i = 0;
                            i < matches.length &&
                            i < this.options.maxInputs - numberOfInputs;
                            i++
                        ) {
                            addTagElement(matches[i], box);
                        }
                    }
                }

                // Update last value
                this.lastValue = value;
            });
        });
    };

    // Add tag element
    var addTagElement = (text, box) => {
        text = text.substr(0, text.length - 1);

        // Create new input
        var input = document.createElement("input");
        input.type = "hidden";
        input.value = text;
        input.name = this.options.inputName; // Input's name

        // Create span to contain the input
        var span = document.createElement("span");
        span.classList.add(this.options.tagClass);
        span.innerHTML = "<span>" + text + "</span>";
        span.style.position = "relative";

        // Create x icon
        var xIcon = document.createElement("span");
        xIcon.innerHTML = this.options.close;
        xIcon.style.position = "absolute";
        xIcon.classList.add("times");

        // Remove remove the tag on click on the span
        xIcon.addEventListener("click", () => {
            span.parentNode.removeChild(span);
        });

        // Append child to span container
        span.appendChild(input);
        span.appendChild(xIcon);

        // Append the tag to the parent element before the tag box
        box.parentNode.insertBefore(span, box);
        // Reset the value of the box
        box.value = "";
    };
})();

let wordsContainer = document.querySelector("#words-continer");
let wordsCounter = 0;

if (wordsContainer) {
    // Clone first child
    // First child
    let firstElementChild = wordsContainer.firstElementChild.cloneNode(true);
    wordsContainer.appendChild(firstElementChild);

    setInterval(() => {
        moveWords(wordsCounter++);
    }, 5000);
}

function moveWords(index) {
    let words = wordsContainer.querySelectorAll("span");

    index = index % words.length;

    // Position
    let position = -(index * 50);

    words.forEach(w => {
        w.style.transform = "translateY(" + position + "px)";
    });

    if (index == words.length - 1) {
        wordsCounter = 1;
        setTimeout(() => {
            let position = -(0 * 50);
            words.forEach(w => {
                w.style.transition = "none";
            });
            words.forEach(w => {
                w.style.transform = "translateY(" + position + "px)";
            });
            setTimeout(() => {
                words.forEach(w => {
                    w.style.transition = ".6s 0s ease-in-out";
                });
            }, 100);
        }, 500);
    }
}
