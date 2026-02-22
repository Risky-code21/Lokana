export default (
    initialLikes,
    initialIsLiked,
    isAuthenticated,
    model,
    slug,
) => ({
    // Inisialisasi State awal dari parameter
    likesCount: initialLikes,
    isLiked: initialIsLiked,

    // Sistem toggled yang akan berjalan ketika event prevent default dari form berjalan
    toggled(event) {
        // Cek apakah user saat ini adalah user yang sudah login ? kalau belum kita return pop up untuk mengarahkannya untuk login
        if (!isAuthenticated) {
            event.preventDefault();
            window.dispatchEvent(new CustomEvent("open-auth-modal"));
            return;
        }

        const form = event.target;

        // Optimistic UI Update
        // Memastikan apakah state saat ini memang sudah like atau belum
        this.isLiked = !this.isLiked;
        this.likesCount = this.isLiked
            ? this.likesCount + 1
            : this.likesCount - 1;

        // Fetch ke route untuk create like
        fetch(form.action, {
            method: "POST",
            body: new FormData(form),
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
        }).catch((error) => {
            // Revert jika gagal
            this.isLiked = !this.isLiked;
            this.likesCount = this.isLiked
                ? this.likesCount + 1
                : this.likesCount - 1;
            console.error("Error:", error);
        });
    },

    // Listener untuk mendengar channel yang berisi data yang dibutuhkan untuk penambahan like komentar pada likeToggled event
    init() {
        window.Echo.channel(`${model}.${slug}`).listen(
            ".LikeToggled",
            (event) => {
                this.likesCount = event.likes_count;
            },
        );
    },
});
