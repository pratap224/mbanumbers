module AdsenseHelper

 def ad_unit(type, client = "pub-xxxxxxxxxxxxxxxx", options = {})
units = {
:leader_board => "728x90",
:wide_skyscraper => "160x600",
:banner => "468x60",
:half_banner => "468x30",
:skyscraper => "120x600",
:vertical_banner => "120x240",
:large_rectangle => "336x280",
:medium_rectangle => "300x250",
:square => "250x250",
:small_square => "200x200",
:small_rectangle => "180x150",
:button => "125x125"
}
 
unit = units[type]
width, height = unit.split("x")
opts = {}
opts[:google_ad_client] = client
opts[:google_ad_width] = width.to_i
opts[:google_ad_height] = height.to_i
if options[:slot]
opts[:google_ad_slot] = options[:slot]
else
opts[:google_ad_type] = options[:type]
opts[:google_ad_format] = "#{unit}_as"
if options[:theme]
opts[:google_color_border] = options[:theme][:border]
opts[:google_color_link] = options[:theme][:link]
opts[:google_color_background] = options[:theme][:background]
opts[:google_color_text] = options[:theme][:text]
opts[:google_color_url] = options[:theme][:url]
end
end
adsense_opts = opts.map do |k, v|
v = v.is_a?(String) ? "\"#{v}\"" : v
"#{k} = #{v};" unless v.blank?
end.compact.sort.join("\n")
content_tag(:div, [javascript_tag(adsense_opts), content_tag(:script, nil, :type => "text/javascript",
:src => "http://pagead2.googlesyndication.com/pagead/show_ads.js")].join("\n").html_safe, :class => "google_adsense #{type}")
end
 
end 