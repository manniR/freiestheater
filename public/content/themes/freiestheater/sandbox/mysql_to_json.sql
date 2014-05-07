/*
MySQL to JSON
*/

SELECT
     CONCAT('[',
          GROUP_CONCAT('{\"username\":','\"',username,'\",',
                        '\"email\":,'\"',email, '\"}')
          )
     ,']') 
AS json FROM users;

SELECT

        CONCAT('[',
            GROUP_CONCAT('{ \"meta_id\":','\"',e.meta_id,'\",'
                          ,'\"meta_value\": ','\"',from_unixtime(e.meta_value),'\"}' )

            ,']') as post_events_json

/*
 OUTPUTS:

[
     {username:'mike',email:'mike@mikesplace.com'},
     {username:'jane',email:'jane@bigcompany.com'},
     {username:'stan',email:'stan@stanford.com'}
]

 */

