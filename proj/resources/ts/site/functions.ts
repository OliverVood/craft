function getMessageBlock(html: string | UIElement): UIElement {
	return el('<div/>', {class: 'message'}).append(
		html
	);
}

(globalThis as any).getMessageBlock = getMessageBlock;