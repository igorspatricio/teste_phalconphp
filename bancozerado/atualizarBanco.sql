CREATE TABLE tags (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `tag` varchar(255),
    PRIMARY KEY (`id`)
    
);



create table `relacaoTagNoticia`(
	`tag_id` int(11),
    `noticia_id` int(11)
    );
    
ALTER TABLE `relacaoTagNoticia` ADD CONSTRAINT `fk_tag` FOREIGN KEY ( `tag_id` ) REFERENCES `tags` ( `id` );
ALTER TABLE `relacaoTagNoticia` ADD CONSTRAINT `fk_noticia` FOREIGN KEY ( `noticia_id` ) REFERENCES `noticia` ( `id` );