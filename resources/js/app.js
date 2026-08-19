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
