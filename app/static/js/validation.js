document.addEventListener("DOMContentLoaded", function () {

    document.getElementById("book").addEventListener("input", function () {
        this.value = this.value.replace(/[^a-zA-ZА-Яа-яёЁ0-9\s.,№"'-]/g, '');
    });

    document.getElementById("author").addEventListener("input", function () {
        this.value = this.value.replace(/[^a-zA-ZА-Яа-яёЁ\s.,-]/g, '');
    });

    document.getElementById("year").addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, '');
    });

    document.getElementById("isbn").addEventListener("input", function () {
        let value = this.value.replace(/\D/g, '');
        if (value.length > 13) {
            value = value.substring(0, 13);
        }
        this.value = value;
    });

    document.getElementById("pages").addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, '');
    });

    document.getElementById("weight").addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, '');
    });

    document.getElementById("price").addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, '');
    });
});