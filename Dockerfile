FROM node:15 as developer

RUN apt-get -yq update && \
    apt-get -yqq install \
    libzip-dev git ssh zip imagemagick && \
    npm install -g npm

RUN curl -s https://packagecloud.io/install/repositories/github/git-lfs/script.deb.sh | bash && \
    apt-get install git-lfs # && git lfs install

RUN mkdir -p ~/.ssh && ssh-keyscan -H github.com >>~/.ssh/known_hosts

WORKDIR /usr/src/app

ENV PATH="/usr/src/app/node_modules/.bin:$PATH"

ENTRYPOINT ["make"]
CMD ["start"]

FROM developer as builder
CMD ["build-all"]
