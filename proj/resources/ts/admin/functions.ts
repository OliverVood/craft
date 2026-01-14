/**
 * Разворачивает / сворачивает содержимое элемента меню.
 * @param head
 */
function toggleMenuItem(head: UIElement) {
	let block = head.parent() as UIElement;
	block.toggleClass('close');
}

(globalThis as any).toggleMenuItem = toggleMenuItem;