import "./bootstrap";

window.PortalSearch = {
    normalize(value) {
        return String(value || "")
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .replace(/[đĐ]/g, "d")
            .toLowerCase()
            .replace(/\s+/g, " ")
            .trim();
    },

    matchesSubsequence(haystack, needle) {
        const text = this.normalize(haystack).replace(/\s+/g, "");
        const query = this.normalize(needle).replace(/\s+/g, "");

        if (!query) {
            return true;
        }

        let index = 0;
        for (let i = 0; i < text.length && index < query.length; i++) {
            if (text[i] === query[index]) {
                index++;
            }
        }

        return index === query.length;
    },
};

/**
 * PortalGridAutofit — giãn cột bảng chi tiết theo đúng nội dung dữ liệu.
 *
 * Bảng có class `js-autofit` sẽ được đo lại độ rộng từng cột bằng canvas
 * (dùng font thật của ô) rồi set `style.width` cho cả header lẫn body, nhờ đó
 * cột rộng vừa khít nội dung thay vì chia đều. Ô trong cột `data-no-fit`
 * (nút thao tác) không tham gia đo nội dung text mà lấy theo phần tử con.
 *
 * Trigger: lần load đầu, resize, Livewire navigate, sự kiện input/change do
 * người dùng gõ, và polling nhẹ so signature giá trị để bắt các thay đổi do
 * server tính lại (ô readonly) hoặc thêm/xoá dòng.
 */
window.PortalGridAutofit = (() => {
    const ctx = document.createElement("canvas").getContext("2d");

    // Chromium có thể trả chuỗi rỗng cho shorthand `.font` → ghép từ longhand.
    const fontOf = (el) => {
        const s = getComputedStyle(el);
        return `${s.fontWeight} ${s.fontSize} ${s.fontFamily}`;
    };

    const padBox = (el) => {
        const s = getComputedStyle(el);
        return (
            parseFloat(s.paddingLeft) +
            parseFloat(s.paddingRight) +
            parseFloat(s.borderLeftWidth) +
            parseFloat(s.borderRightWidth)
        );
    };

    const fitTable = (table) => {
        const ths = [...table.querySelectorAll("thead th")];
        const firstTd = table.querySelector("tbody td");
        if (!firstTd || firstTd.colSpan > 1) return; // trạng thái chưa có dòng

        const widths = [];
        ths.forEach((th, i) => {
            ctx.font = fontOf(th);
            widths[i] = Math.ceil(
                ctx.measureText(th.textContent.trim()).width + padBox(th),
            );
        });

        table.querySelectorAll("tbody tr").forEach((tr) => {
            [...tr.children].forEach((td, i) => {
                const input = td.querySelector("input");
                if (!input) {
                    const el = td.firstElementChild;
                    if (el && ths[i] && !ths[i].hasAttribute("data-no-fit")) {
                        widths[i] = Math.max(
                            widths[i],
                            Math.ceil(el.getBoundingClientRect().width),
                        );
                    }
                    return;
                }
                ctx.font = fontOf(input);
                // number input có spinner của trình duyệt, chừa chỗ cho nó.
                const spinPad = input.type === "number" ? 14 : 0;
                widths[i] = Math.max(
                    widths[i],
                    Math.ceil(
                        ctx.measureText(String(input.value ?? "")).width +
                            padBox(input) +
                            spinPad,
                    ),
                );
            });
        });

        const apply = (row) =>
            [...row.children].forEach((cell, i) => {
                if (widths[i] != null) cell.style.width = `${widths[i]}px`;
            });

        apply(table.querySelector("thead tr"));
        table.querySelectorAll("tbody tr").forEach(apply);
    };

    const fitAll = () =>
        document.querySelectorAll("table.js-autofit").forEach(fitTable);
    const run = () => requestAnimationFrame(fitAll);

    let lastSignature = "";

    return {
        run,
        fitAll,
        install() {
            run();
            window.addEventListener("resize", run);
            document.addEventListener("livewire:navigated", run);

            const fromGrid = (e) =>
                !!(
                    e.target &&
                    e.target.closest &&
                    e.target.closest("table.js-autofit")
                );
            document.addEventListener("input", (e) => fromGrid(e) && run());
            document.addEventListener("change", (e) => fromGrid(e) && run());

            setInterval(() => {
                const inputs = document.querySelectorAll(
                    "table.js-autofit tbody input",
                );
                const rows = document.querySelectorAll(
                    "table.js-autofit tbody tr",
                );
                const signature = `${rows.length}\u0001${[...inputs].map((i) => i.value).join("\u0001")}`;
                if (signature !== lastSignature) {
                    lastSignature = signature;
                    run();
                }
            }, 400);
        },
    };
})();

window.PortalGridAutofit.install();
