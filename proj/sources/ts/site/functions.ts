function getMessageBlock(html: string | JQuery): JQuery {
	return $('<div/>', {class: 'message'}).append(
		html
	);
}

(globalThis as any).getMessageBlock = getMessageBlock;