
set :stages, %w(production staging)
set :default_stage, "staging"

require 'capistrano/ext/multistage'

set :application, "api.fotonatorte.ru"

role :app, "178.250.241.76"
role :web, "178.250.241.76"
role :db,  "178.250.241.76", :primary => true

set :scm, :git
set :scm_verbose, true
set :git_enable_submodules, true

set :repository,  "git@github.com:kononencheg/Photo-Cake-API.git"

default_run_options[:pty] = true

set :ssh_options, { :forward_agent => true }
set :use_sudo, false

