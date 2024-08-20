import { selectAll } from "./lib.js";

const allItemTitles = selectAll(":is(h5, h6).item-title");

allItemTitles.forEach((itemTitle) => {
	itemTitle.innerHTML = localStorage.getItem("school_name");
});
