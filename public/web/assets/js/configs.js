AOS.init({
    once: true,
});

window.onscroll = function() {
    scrollFunction();
};

function scrollFunction() {
    const scrollTopBtn = document.getElementById("top-btn");
    if (document.body.scrollTop > document.body.scrollHeight * 0.1 ||
        document.documentElement.scrollTop > document.documentElement.scrollHeight * 0.1) {
        scrollTopBtn.classList.remove('d-none');
        scrollTopBtn.classList.add('d-flex');
    } else {
        scrollTopBtn.classList.add('d-none');
        scrollTopBtn.classList.remove('d-flex');
    }
}

document.getElementById("top-btn").onclick = function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
    this.classList.add('d-none');
    this.classList.remove('d-flex');
};