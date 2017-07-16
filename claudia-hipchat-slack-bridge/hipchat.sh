# 


#curl -X POST -H "Content-Type: application/json" \
# -H "Authorization: Bearer ASDFASDFASDFASDF" \
# -d "{\"url\":\"https://7zzqlki0g1.execute-api.us-west-2.amazonaws.com/latest/bridge/theclub-club\",\"event\": \"room_message\"}" \
# https://api.hipchat.com/v2/room/2248197/webhook

curl -X POST -H "Content-Type: application/json" \
 -H "Authorization: Bearer ASDFASDFASDFASDF" \
 -d "{\"url\":\"https://7zzqlki0g1.execute-api.us-west-2.amazonaws.com/latest/bridge/eng\",\"event\": \"room_message\"}" \
 https://api.hipchat.com/v2/room/552648/webhook

#curl -X DELETE -H "Content-Type: application/json" \
# -H "Authorization: Bearer ASDFASDFASDFASDF" \
# https://api.hipchat.com/v2/room/2248197/webhook/4199442
