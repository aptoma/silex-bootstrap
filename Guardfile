# Guard - https://github.com/guard/guard
#
# Usage:
# bundle exec guard
# ---------------------------------------------------------------


## PHP ##
guard 'phpunit', :tests_path => 'tests', :all_on_start => false, :all_after_pass => false, :cli => '--colors --verbose' do
  watch(%r{^(app/.+)\.php})   { |m| "tests/#{m[1]}Test.php" }
  watch(%r{^(src/.+)\.php})   { |m| "tests/#{m[1]}Test.php" }
  watch(%r{^tests/.*\.php$})
end

guard 'phpmd', :rules => 'phpmd.xml' do
  watch(%r{^app/\w*\.php$})
  watch(%r{^src/.*\.php$})
  watch(%r{^tests/.*\.php$})
end

guard 'phpcs', :standard => 'PSR2' do
  watch(%r{^app/\w*\.php$})
  watch(%r{^src/.*\.php$})
  watch(%r{^tests/.*\.php$})
end
