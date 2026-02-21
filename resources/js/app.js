import "./bootstrap";

import Alpine from "alpinejs";
import likeButton from "./likeButton";
import commentSection from "./commentSection";
import commentItem from "./CommentItem";

// Insialisasi alpine js sebagai object global
window.Alpine = Alpine;

// Daftarkan module yang telah dibuat kedalam alpine js
// Modul untuk toggled like
Alpine.data("likeButton", likeButton);

// Modul untuk section komentar utama pada detail article
Alpine.data("commentSection", commentSection);

// Modul untuk component bubble
Alpine.data("commentItem", commentItem);

// Mulai alpine js
Alpine.start();
