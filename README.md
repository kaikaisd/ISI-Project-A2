# ISI-Project-A2

---
# How to use
1. clone this project to your pc
2. copy `.env.example` to `.env`
3. `php artisan key:generate`
4. Run `alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'` in your terminal if `sail` command not found
5. `sail up -d` For set the docker container
6. `sail npm i` For install the node modules
7. `sail npm run dev` For run the development mode
8. Use your browser to `http://localhost` to see the result

---
# How to seeding data
`sail artisan migrate:fresh --seed` use this command to seeding and migrate data


---

## Requirement
- ### Frontend
    - vue.js
    - UI Framework to be discussed

- ### Backend
    - Laravel w/ Lunar

## Documents
- ### Backend
    - [Lunar](https://docs.lunarphp.io/)
    - [Laravel structure](https://learnku.com/docs/laravel/9.x)

- ### FrontEnd
    - 

