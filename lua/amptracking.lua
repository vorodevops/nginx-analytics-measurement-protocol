local request = {
  v = 1,
  tid = ngx.var.ua_property,
  t = "pageview",
  dp = ngx.var.uri,
  cid = string.sub(ngx.var.uid_anon, 5)
}

local headers = ngx.req.get_headers()
if headers.dnt == nil then
  request["uip"] = ngx.var.remote_addr
  request["ua"] = ngx.var.http_user_agent
  request["ul"] = ngx.var.http_accept_language
end


local res = ngx.location.capture(
  "/amp-collect",
  {
    method = ngx.HTTP_POST,
    body = ngx.encode_args(request)
  }
)
