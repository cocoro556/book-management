function openModal(modalId) {
    document.getElementById(modalId).style.display = "block";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

// モーダル外クリックで閉じる
window.onclick = function (event) {
    const modals = document.querySelectorAll(".modal");
    modals.forEach((modal) => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
};

function showPage(page) {
    alert(`${page}ページに移動します（実装予定）`);
}

// 詳細ボタンクリック時
function showBookDetail(bookId) {
    // Ajax でデータを取得
    fetch(`/api/books/${bookId}`)
        .then((response) => response.json())
        .then((data) => {
            // モーダル内容を動的に更新
            const modalElement = document.querySelector(
                "#detailModal .modal-content"
            );
            if (modalElement) {
                modalElement.innerHTML = `
        <h3>📖 ${data.title}</h3>
        <div style="margin: 1rem 0;">
            <p><strong>著者:</strong> ${data.author}</p>
            <p><strong>ジャンル:</strong> ${data.genre}</p>
            <p><strong>出版年:</strong> ${
                data.publication_year
            }年</p>
            <p><strong>ISBN:</strong> ${data.isbn || "未設定"}</p>
        </div>
        <div style="text-align: right;">
            <button type="button" onclick="closeModal('detailModal')" class="btn">閉じる</button>
        </div>
    `;

                // モーダル表示
                const modal =
                    document.querySelector("#detailModal");
                if (modal) {
                    modal.style.display = "block";
                }
            }
        })
        .catch((error) => {
            alert("データの取得に失敗しました");
        });
}