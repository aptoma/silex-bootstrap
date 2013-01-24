# Install Bundler using:
# `gem install bundler`
#
# Then use `bundle install` to install gem dependencies.
#
# Use `--without guard` or `--without capistrano` if you don't want to install all dependencies

source "https://rubygems.org"

group :guard do
  gem "guard",            "~>1.5"
  gem "guard-phpunit",    "~>0.1.4"
  gem "guard-phpmd",      "~>0.0.2"
  gem "guard-phpcs"
  gem "guard-shell",      "~>0.5.1"
  gem "rb-fsevent",       "~>0.9.2"
  gem "growl",            "~>1.0"
end

group :capistrano do
  gem "capistrano",       "~>2.13"
  gem "capistrano-ext",   "~>1.2"
  gem "railsless-deploy", "~>1.0"
  gem "colored",          "~>1.2"
  gem "hipchat",          "~> 0.7.0"
end

group :development do
  gem 'rb-readline'
end
