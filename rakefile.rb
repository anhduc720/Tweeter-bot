#!/usr/bin/env ruby
require 'net/http'
require 'json'

url = 'http://twiterbot.herokuapp.com/index.php/cron'
uri = URI(url)
response = Net::HTTP.get(uri)