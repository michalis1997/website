USE web_project;

/* TABLES */
select * from registration;
select * from UploadUserHistory;
select * from entries;
select * from req_res_head;
select * from responseIP;

/* USER - heatmap */
SELECT responseip.harIPAddress , responseip.latitude, responseip.longitude, count(entries.serverIPAddress) AS count FROM UploadUserHistory
                    INNER JOIN entries ON UploadUserHistory.har_id = entries.har_id
                    INNER JOIN req_res_head ON entries.id = req_res_head.entry_id
                    INNER JOIN responseip ON entries.serverIPAddress = responseip.harIPAddress
                    WHERE UploadUserHistory.user_id = 5 AND (req_res_head.res_h_value LIKE '%html%' 
                                                                        OR req_res_head.res_h_value LIKE '%php%'
                                                                        OR req_res_head.res_h_value LIKE '%asp%' 
                                                                        OR req_res_head.res_h_value LIKE '%jsp%'
                                                                        OR req_res_head.res_h_value LIKE '%xml%'
                                                                        OR req_res_head.res_h_value LIKE '%text%'
                                                                        OR req_res_head.res_h_value LIKE '%json%'
                                                                        OR req_res_head.res_h_value LIKE '%application%')
                    GROUP BY entries.serverIPAddress;
                    
/* reset heatmap data */
DELETE responseip FROM responseip 
                        INNER JOIN entries ON responseIP.harIPAddress = entries.serverIPAddress
                        INNER JOIN UploadUserHistory ON entries.har_id = UploadUserHistory.har_id
                        INNER JOIN registration ON UploadUserHistory.user_id = registration.id
                        WHERE registration.id= USER_ID;
                        
/* ADMIN 1a */
select count(id) as num_of_registrations from registration;
/* ADMIN 1b */
select req_method as method_type, count(req_method) as num_of_rec_per_method from req_res_head GROUP BY req_method HAVING count(req_method) > 0;
/* ADMIN 1c */
select res_status as response_code, count(res_status) as num_of_rec_per_status from req_res_head GROUP BY res_status HAVING count(res_status) > 0 AND (response_code) > 0 ORDER BY response_code ASC;
/* ADMIN 1d */
select distinct req_url as domain, count(req_url) as num_of_rec_per_domain from req_res_head GROUP BY req_url HAVING count(req_url) > 0;
select count(distinct req_url) as num_of_dist_domains from req_res_head;
/* ADMIN 1e */
select userIPAddress as User_ISP_Domain, count(userIPAddress) as num_of_isp_in_db from UploadUserHistory GROUP BY userIPAddress HAVING count(userIPAddress) >0;
select count(distinct userIPAddress) as num_of_dist_isp_domains from UploadUserHistory;
/* ADMIN 1f */
SELECT A.res_h_value AS content_type_res, A.res_h_name, B.res_h_name, B.res_h_value, ROUND(AVG(B.res_h_value)) AS average_age_per_ct
                                FROM req_res_head AS A
                                INNER JOIN req_res_head AS B ON A.entry_id = B.entry_id
                                WHERE (A.req_h_name = 'content-type' AND B.req_h_name='age') OR (A.res_h_name = 'content-type' AND B.res_h_name='age')
                                GROUP BY A.res_h_value
                                ORDER BY average_age_per_ct DESC;








/* ================================================================= ADMIN 2,3 ================================================================================== */

/* ADMIN 2 -> LISTA ME EPILOGES a, b, c, d*/
select startedDateTime , timings_wait from entries;
/* ADMIN 2a */
select id, entry_id, res_h_value from req_res_head where res_h_name = 'content-type';


/* ADMIN 2a */
SELECT entries.id, entries.startedDateTime, req_res_head.res_h_name, req_res_head.res_h_value, entries.timings_wait FROM entries
INNER JOIN req_res_head ON entries.id = req_res_head.entry_id
WHERE (req_h_name = 'content-type' OR res_h_name= 'content-type') AND ( (req_h_value LIKE 'application%' OR res_h_value LIKE 'application%') OR 
																		(req_h_value LIKE 'text%' OR res_h_value LIKE 'text%')   OR
                                                                        (req_h_value LIKE 'html%' OR res_h_value LIKE 'html%')   OR
                                                                        (req_h_value LIKE 'image%' OR res_h_value LIKE 'image%') OR
                                                                        (req_h_value LIKE 'audio%' OR res_h_value LIKE 'audio%') OR
                                                                        (req_h_value LIKE 'video%' OR res_h_value LIKE 'video%') OR
                                                                        (req_h_value LIKE 'font%' OR res_h_value LIKE 'font%') )
GROUP BY entries.startedDateTime 
GROUP BY req_h_value LIKE 'application%', res_h_value LIKE 'application%';

SELECT entries.startedDateTime, req_res_head.res_h_name, req_res_head.res_h_value, entries.timings_wait FROM entries
INNER JOIN req_res_head ON entries.id = req_res_head.entry_id
WHERE ( res_h_name= 'content-type') AND (req_h_value LIKE 'application%' OR res_h_value LIKE 'application%')
GROUP BY entries.startedDateTime ;

/* ================================================================= ADMIN 2,3 ================================================================================== */












/* ADMIN 4 */
SELECT  UploadUserHistory.user_id as userID, 
                        entries.har_id, 
                        UploadUserHistory.userIPAddress as userIP, 
                        UploadUserHistory.latitude as userLat, 
                        UploadUserHistory.longitude as userLong, 
                        responseip.harIPAddress as responseIP, 
                        responseip.latitude as resLat, 
                        responseip.longitude as resLong, 
                        count(entries.serverIPAddress) AS count 
                        FROM UploadUserHistory
                        INNER JOIN entries ON UploadUserHistory.har_id = entries.har_id
                        INNER JOIN responseip ON entries.serverIPAddress = responseip.harIPAddress
                        GROUP BY user_id, har_id, responseip.harIPAddress;

/* ADMIN 4 - find max from count */
SELECT MAX(counter) AS res_ip_counter FROM (
SELECT  UploadUserHistory.user_id as userID, 
                        entries.har_id, 
                        UploadUserHistory.userIPAddress as userIP, 
                        UploadUserHistory.latitude as userLat, 
                        UploadUserHistory.longitude as userLong, 
                        responseip.harIPAddress as responseIP, 
                        responseip.latitude as resLat, 
                        responseip.longitude as resLong, 
                        count(entries.serverIPAddress) AS counter 
                        FROM UploadUserHistory
                        INNER JOIN entries ON UploadUserHistory.har_id = entries.har_id
                        INNER JOIN responseip ON entries.serverIPAddress = responseip.harIPAddress
                        GROUP BY user_id, har_id, responseip.harIPAddress) as counts;







