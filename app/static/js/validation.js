document.addEventListener("DOMContentLoaded", function () {
    function clean_input(value, regex) {
        value = value.replace(regex, '');
        value = value.replace(/([^\wа-яА-ЯёЁ])\1+/g, '$1');
        value = value.replace(/^[^a-zA-ZА-Яа-яёЁ0-9]+/, '');
        return value;
    }

    document.getElementById("book").addEventListener("input", function () {
        this.value = clean_input(this.value, /[^a-zA-ZА-Яа-яёЁ0-9\s.,№"'-()]/g);
    });

    document.getElementById("author").addEventListener("input", function () {
        this.value = clean_input(this.value, /[^a-zA-ZА-Яа-яёЁ\s.,-]/g);
    });

    document.getElementById("year").addEventListener("input", function () {
        this.value = clean_input(this.value, /\D/g);
    });

    document.getElementById("isbn").addEventListener("input", function () {
        let value = this.value.replace(/\D/g, '').slice(0, 13);
        this.value = value;
        
        if (value.length < 13) {
            this.classList.add("error");
        } else {
            this.classList.remove("error");
        }
    });

    document.getElementById("pages").addEventListener("input", function () {
        this.value = clean_input(this.value, /\D/g);
    });
});