export default (articleSlug, initialHasMore, viewerId) => ({
    // State Pagination & Loading
    page: 1,
    hasMore: initialHasMore,
    isLoading: false,
    currentViewerId: viewerId,

    // Fungsi Submit Komentar Utama
    submitKomentar(event) {
        const form = event.target;

        fetch(form.action, {
            method: "POST",
            body: new FormData(form),
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "success") {
                    form.reset(); // Kosongkan text area
                }
            })
            .catch((error) => console.error("Error:", error));
    },

    // Fungsi Load More
    loadMore() {
        if (this.isLoading) return;

        this.isLoading = true;
        this.page++;

        fetch(`?page=${this.page}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                const pageWrapper = `<div id='comment-page-${this.page}' x-data x-transition>${data.html}</div>`;
                document
                    .getElementById("comments-list-container")
                    .insertAdjacentHTML("beforeend", pageWrapper);
                this.hasMore = data.hasMore;
            })
            .catch((error) => console.error("Error:", error))
            .finally(() => {
                this.isLoading = false;
            });
    },

    // Fungsi Show Less
    showLess() {
        if (this.page <= 1) return;

        const lastPage = document.getElementById(`comment-page-${this.page}`);
        if (lastPage) {
            lastPage.remove();
        }

        this.page--;
        this.hasMore = true;
    },

    // Inisialisasi Real-time Reverb
    init() {
        window.Echo.channel(`article.${articleSlug}`).listen(
            "CommentPosted",
            (event) => {
                document
                    .getElementById("comments-list-container")
                    .insertAdjacentHTML("afterbegin", event.html);
            },
        );
    },
});
