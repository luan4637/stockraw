CREATE OR REPLACE VIEW transaction_view AS
SELECT t.`code`,
	IFNULL( (SELECT vol FROM `transaction` WHERE `code` = t.`code` AND `date` = (SELECT `date` FROM `transaction` WHERE `code` = 'VND' ORDER BY `date` DESC LIMIT 0, 1)), 0) AS yesterday,
	IFNULL( (SELECT vol FROM `transaction` WHERE `code` = t.`code` AND `date` = (SELECT `date` FROM `transaction` WHERE `code` = 'VND' ORDER BY `date` DESC LIMIT 1, 1)), 0) AS twoDayAgo,
	IFNULL( (SELECT vol FROM `transaction` WHERE `code` = t.`code` AND `date` = (SELECT `date` FROM `transaction` WHERE `code` = 'VND' ORDER BY `date` DESC LIMIT 2, 1)), 0) AS threeDayAgo
FROM `transaction` AS t
GROUP BY t.`code`;