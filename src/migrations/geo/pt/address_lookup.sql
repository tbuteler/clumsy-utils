create algorithm=undefined sql security definer view `utils_geo_pt_address_lookup`
as select
   `cp`.`CP4` as `code_prefix`,
   `cp`.`CP3` as `code_suffix`,
   `cp`.`ART_TIPO` as `street_type`,
   `cp`.`PRI_PREP` as `street_type_suffix`,
   `cp`.`ART_TITULO` as `street_name_prefix_1`,
   `cp`.`SEG_PREP` as `street_name_prefix_2`,
   `cp`.`ART_DESIG` as `street_name`,
   trim(trailing '\r' from `cp`.`CPALF`) as `city`,
   `cp`.`LOCALIDADE` as `location`,
   `d`.`DESIG` as `region`,
   `c`.`DESIG` as `subregion` from ((`utils_geo_pt_postal_codes` `cp` join `utils_geo_pt_regions` `d` on((`cp`.`DD` = `d`.`DD`))) join `utils_geo_pt_subregions` `c` on(((`cp`.`CC` = `c`.`CC`) and (`cp`.`DD` = `c`.`DD`))));