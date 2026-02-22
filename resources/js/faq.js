// resources/js/faq.js

const faqData = [
    {
        section: "General Question",
        icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
              <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 0 1-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 0 1-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 0 1-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584ZM12 18a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
            </svg>
            `,
        items: [
            {
                q: "What is Lokana",
                a: "Lokana is a digital platform focused on empowering Balinese MSMEs and artisans by showcasing the stories, cultural values, and creative processes behind each handcrafted product.",
            },
            {
                q: "How does Lokana work?",
                a: "You can explore products, read stories, connect with artisans, and place orders directly through the platform.",
            },
            {
                q: "Is Lokana free to use?",
                a: "Yes, browsing stories and products is free. Certain features may require an account.",
            },
            {
                q: "How to become an UMKM partner?",
                a: "Register as UMKM, complete profile, and submit your product listing.",
            },
        ],
    },
    {
        section: "Ordering & payment",
        icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
              <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd" />
            </svg>
          `,
        items: [
            {
                q: "How to place an order?",
                a: "Choose a product, click order, and follow the checkout instructions.",
            },
            {
                q: "What payment methods are available?",
                a: "Bank transfer, e-wallet, and other available payment gateways.",
            },
            {
                q: "Can I cancel an order?",
                a: "You can cancel before the seller confirms. After confirmation, follow the return policy.",
            },
            {
                q: "How long does shipping take?",
                a: "Shipping time depends on location and courier. Estimated time will appear at checkout.",
            },
        ],
    },
    {
        section: "For artisans",
        icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
              <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z" clip-rule="evenodd" />
              <path fill-rule="evenodd" d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z" clip-rule="evenodd" />
            </svg>
          `,
        items: [
            {
                q: "How to join as an artisan?",
                a: "Sign up, complete artisan profile, and upload your products with photos and descriptions.",
            },
            {
                q: "How do I get featured?",
                a: "Maintain good ratings, complete profile, and consistently upload high-quality products.",
            },
            {
                q: "Do you charge platform fees?",
                a: "Platform fees depend on partnership plan. You can contact us for details.",
            },
            {
                q: "Can I tell my story?",
                a: "Yes, you can publish stories/articles to help customers understand your craftsmanship.",
            },
        ],
    },
];

export function initFAQ() {
    const container = document.getElementById("faq-container");
    if (!container) return;

    let html = "";

    faqData.forEach((group) => {
        html += `
            <div class="mb-10">
                <div class="flex items-center gap-4 mb-6">
                    <span class="size-10 rounded-full bg-surface-medium text-primary-main flex items-center justify-center text-sm shadow-sm">
                        ${group.icon}
                    </span>
                    <h2 class="text-2xl md:text-3xl font-heading text-black font-medium">${group.section}</h2>
                </div>

                <div class="space-y-4">
        `;

        group.items.forEach((item) => {
            html += `
                    <div class="faq-item rounded-btn bg-surface-high overflow-hidden transition-all duration-300">
                        <button class="faq-btn w-full flex justify-between items-center px-8 py-5 text-left focus:outline-none cursor-pointer group">
                            <span class="font-paragraph text-black font-medium pr-4 group-hover:text-primary-main transition-colors">${item.q}</span>
                            
                            <div class="faq-icon shrink-0 w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300 bg-surface-low text-primary-main">
                                <svg class="w-4 h-4 icon-plus" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                <svg class="w-4 h-4 icon-minus hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                        </button>
                        
                        <div class="faq-content hidden px-8 pb-6 pt-0 text-text-body font-paragraph text-sm leading-relaxed">
                            ${item.a}
                        </div>
                    </div>
            `;
        });

        html += `</div></div>`;
    });

    container.innerHTML = html;
    attachEvents();
}

function attachEvents() {
    const items = document.querySelectorAll(".faq-item");

    items.forEach((item) => {
        const btn = item.querySelector(".faq-btn");
        const content = item.querySelector(".faq-content");
        const iconContainer = item.querySelector(".faq-icon");
        const iconPlus = item.querySelector(".icon-plus");
        const iconMinus = item.querySelector(".icon-minus");

        btn.addEventListener("click", () => {
            const isOpen = !content.classList.contains("hidden");

            // 1. Tutup semua akordion terlebih dahulu
            items.forEach((i) => {
                i.querySelector(".faq-content").classList.add("hidden");
                i.classList.remove(
                    "bg-surface-medium",
                    "border-l-4",
                    "border-primary-main",
                );
                i.classList.add("bg-surface-high");

                const iIcon = i.querySelector(".faq-icon");
                iIcon.classList.remove("bg-primary-main", "text-white");
                iIcon.classList.add("bg-surface-low", "text-primary-main");

                i.querySelector(".icon-plus").classList.remove("hidden");
                i.querySelector(".icon-minus").classList.add("hidden");
            });

            // 2. Jika item yang diklik sebelumnya tertutup, maka buka
            if (!isOpen) {
                content.classList.remove("hidden");

                // Ubah gaya box aktif sesuai desain
                item.classList.remove("bg-surface-high");
                item.classList.add(
                    "bg-surface-medium",
                    "border-l-4",
                    "border-primary-main",
                );

                // Ubah gaya ikon aktif (lingkaran coklat, tanda X putih)
                iconContainer.classList.remove(
                    "bg-surface-low",
                    "text-primary-main",
                );
                iconContainer.classList.add("bg-primary-main", "text-white");

                iconPlus.classList.add("hidden");
                iconMinus.classList.remove("hidden");
            }
        });
    });
}
